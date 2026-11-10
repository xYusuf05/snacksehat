import os
import pickle
import logging
from flask import Flask, request, jsonify
from flask_cors import CORS

# ─── Setup ─────────────────────────────────────────────────────────────────────
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
logging.basicConfig(level=logging.INFO, format="%(asctime)s [%(levelname)s] %(message)s")

app = Flask(__name__)
CORS(app)  # izinkan request dari Laravel

# ─── Load Model ────────────────────────────────────────────────────────────────
def load_artifacts():
    model_path   = os.path.join(BASE_DIR, "cart_model.pkl")
    encoder_path = os.path.join(BASE_DIR, "label_encoder.pkl")

    if not os.path.exists(model_path) or not os.path.exists(encoder_path):
        raise FileNotFoundError(
            "Model belum dilatih. Jalankan dulu: python train_model.py"
        )

    with open(model_path, "rb") as f:
        model = pickle.load(f)
    with open(encoder_path, "rb") as f:
        le = pickle.load(f)

    logging.info("✅ Model CART berhasil dimuat.")
    return model, le


try:
    model, label_encoder = load_artifacts()
except FileNotFoundError as e:
    logging.warning(str(e))
    model, label_encoder = None, None


# ─── Helper ────────────────────────────────────────────────────────────────────
REQUIRED_FIELDS = ["gula", "natrium", "lemak", "serat"]

def validate_input(data: dict):
    """Validasi field dan tipe data."""
    errors = {}
    for field in REQUIRED_FIELDS:
        if field not in data:
            errors[field] = f"Field '{field}' wajib diisi."
            continue
        try:
            val = float(data[field])
            if val < 0:
                errors[field] = f"Field '{field}' tidak boleh negatif."
        except (ValueError, TypeError):
            errors[field] = f"Field '{field}' harus berupa angka."
    return errors


def rule_based_classify(gula, natrium, lemak, serat):
    """
    Fallback: aturan klasifikasi manual (digunakan bila model belum dilatih).
    Mengikuti spesifikasi proposal penelitian.
    """
    if gula <= 5 and lemak <= 3 and natrium <= 140 and serat >= 3:
        return "Snack Sehat"
    elif gula > 10 and lemak > 8 or natrium > 300:
        return "Klaim Sehat Diragukan"
    else:
        return "Perlu Perhatian"


# ─── Routes ────────────────────────────────────────────────────────────────────
@app.route("/", methods=["GET"])
def index():
    return jsonify({
        "service": "Snack Classifier API",
        "version": "1.0.0",
        "status":  "running",
        "model_loaded": model is not None,
        "endpoints": {
            "POST /predict": "Klasifikasi snack berdasarkan kandungan gizi",
            "GET  /health":  "Cek status layanan",
        }
    })


@app.route("/health", methods=["GET"])
def health():
    return jsonify({
        "status":       "ok",
        "model_loaded": model is not None,
        "classes":      list(label_encoder.classes_) if label_encoder else []
    })


@app.route("/predict", methods=["POST"])
def predict():
    # ── Pastikan JSON ──
    if not request.is_json:
        return jsonify({"error": "Content-Type harus application/json"}), 415

    data = request.get_json(silent=True)
    if not data:
        return jsonify({"error": "Body JSON tidak valid atau kosong"}), 400

    # ── Validasi ──
    errors = validate_input(data)
    if errors:
        return jsonify({"error": "Validasi gagal", "detail": errors}), 422

    gula    = float(data["gula"])
    natrium = float(data["natrium"])
    lemak   = float(data["lemak"])
    serat   = float(data["serat"])

    # ── Prediksi ──
    if model and label_encoder:
        features  = [[gula, natrium, lemak, serat]]
        pred_enc  = model.predict(features)[0]
        hasil     = label_encoder.inverse_transform([pred_enc])[0]
        # Probabilitas tiap kelas
        proba     = model.predict_proba(features)[0]
        confidence = {
            label_encoder.classes_[i]: round(float(p) * 100, 2)
            for i, p in enumerate(proba)
        }
        method = "CART Decision Tree"
    else:
        # Fallback rule-based
        hasil      = rule_based_classify(gula, natrium, lemak, serat)
        confidence = {}
        method     = "Rule-Based (fallback)"

    logging.info(
        "Prediksi: gula=%.1f natrium=%.1f lemak=%.1f serat=%.1f → %s",
        gula, natrium, lemak, serat, hasil
    )

    return jsonify({
        "hasil":      hasil,
        "confidence": confidence,
        "method":     method,
        "input": {
            "gula":    gula,
            "natrium": natrium,
            "lemak":   lemak,
            "serat":   serat,
        }
    })


@app.route("/batch-predict", methods=["POST"])
def batch_predict():
    """Prediksi banyak snack sekaligus (untuk import data)."""
    if not request.is_json:
        return jsonify({"error": "Content-Type harus application/json"}), 415

    data = request.get_json(silent=True)
    if not isinstance(data, list):
        return jsonify({"error": "Body harus berupa array JSON"}), 400

    results = []
    for i, item in enumerate(data):
        errors = validate_input(item)
        if errors:
            results.append({"index": i, "error": errors})
            continue

        gula    = float(item["gula"])
        natrium = float(item["natrium"])
        lemak   = float(item["lemak"])
        serat   = float(item["serat"])

        if model and label_encoder:
            pred_enc = model.predict([[gula, natrium, lemak, serat]])[0]
            hasil    = label_encoder.inverse_transform([pred_enc])[0]
        else:
            hasil = rule_based_classify(gula, natrium, lemak, serat)

        results.append({
            "index": i,
            "nama_produk": item.get("nama_produk", f"Snack-{i+1}"),
            "hasil": hasil,
        })

    return jsonify({"total": len(results), "results": results})


# ─── Entrypoint ────────────────────────────────────────────────────────────────
if __name__ == "__main__":
    app.run(host="0.0.0.0", port=5000, debug=True)