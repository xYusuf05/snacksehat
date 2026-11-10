"""
train_model.py
Script untuk melatih model Decision Tree CART dan menyimpannya sebagai .pkl
Jalankan sekali sebelum menjalankan Flask API: python train_model.py
"""

import pandas as pd
import pickle
import os
from sklearn.tree import DecisionTreeClassifier, export_text
from sklearn.model_selection import train_test_split
from sklearn.metrics import classification_report, accuracy_score
from sklearn.preprocessing import LabelEncoder

# ─── Load Dataset ──────────────────────────────────────────────────────────────
BASE_DIR = os.path.dirname(os.path.abspath(__file__))
df = pd.read_csv(os.path.join(BASE_DIR, "dataset_final.csv"))

print("=" * 55)
print("  TRAINING MODEL CART - KLASIFIKASI SNACK SEHAT")
print("=" * 55)
print(f"\nTotal data: {len(df)} baris")
print(f"\nDistribusi kategori:")
print(df["kategori"].value_counts())

# ─── Fitur & Label ─────────────────────────────────────────────────────────────
FEATURES = ["gula", "natrium", "lemak", "serat"]
TARGET   = "kategori"

X = df[FEATURES]
y = df[TARGET]

# ─── Encode Label ──────────────────────────────────────────────────────────────
le = LabelEncoder()
y_encoded = le.fit_transform(y)

print(f"\nKelas: {list(le.classes_)}")

# ─── Split Data ────────────────────────────────────────────────────────────────
X_train, X_test, y_train, y_test = train_test_split(
    X, y_encoded, test_size=0.2, random_state=42, stratify=y_encoded
)
print(f"\nData training : {len(X_train)} baris")
print(f"Data testing  : {len(X_test)} baris")

# ─── Training CART ─────────────────────────────────────────────────────────────
# criterion="gini" → CART (Gini Impurity)
model = DecisionTreeClassifier(
    criterion="gini",
    max_depth=5,
    min_samples_split=2,
    min_samples_leaf=1,
    random_state=42,
)
model.fit(X_train, y_train)

# ─── Evaluasi ──────────────────────────────────────────────────────────────────
y_pred = model.predict(X_test)
acc    = accuracy_score(y_test, y_pred)

print(f"\nAkurasi Model : {acc * 100:.2f}%")
print("\nClassification Report:")
print(classification_report(y_test, y_pred, target_names=le.classes_))

# ─── Tampilkan Pohon Keputusan ─────────────────────────────────────────────────
print("\nPohon Keputusan (Rules):")
print(export_text(model, feature_names=FEATURES))

# ─── Simpan Model & Encoder ────────────────────────────────────────────────────
model_path   = os.path.join(BASE_DIR, "cart_model.pkl")
encoder_path = os.path.join(BASE_DIR, "label_encoder.pkl")

with open(model_path, "wb") as f:
    pickle.dump(model, f)

with open(encoder_path, "wb") as f:
    pickle.dump(le, f)

print(f"\n✅ Model disimpan   : {model_path}")
print(f"✅ Encoder disimpan : {encoder_path}")
print("\nSiap digunakan oleh Flask API!")
