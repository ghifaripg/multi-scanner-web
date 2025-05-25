import os
import glob
import hashlib
import math
import re
import sys 

def load_all_hashes(directory, prefix):
    hashes = set()
    for path in glob.glob(os.path.join(directory, f"{prefix}_hashes_*.txt")):
        with open(path, "r", encoding="utf-8", errors="ignore") as f:
            for line in f:
                hashes.add(line.strip().lower())
    return hashes

def calculate_entropy(data):
    if not data:
        return 0.0
    entropy = 0
    length = len(data)
    freq = {}
    for byte in data:
        freq[byte] = freq.get(byte, 0) + 1
    for count in freq.values():
        p = count / length
        entropy -= p * math.log2(p)
    return entropy

def load_signatures(path="signatures.txt"):
    signatures = []
    try:
        with open(path, "r", encoding="utf-8", errors="ignore") as f:
            for line in f:
                sig = line.strip()
                if not sig or sig.startswith("#"):
                    continue
                if sig.startswith("REGEX:"):
                    pattern = sig[len("REGEX:"):]
                    try:
                        compiled = re.compile(pattern.encode(), re.IGNORECASE)
                        signatures.append(("regex", compiled))
                    except re.error:
                        print(f"⚠️ Invalid REGEX ignored: {pattern}")
                else:
                    signatures.append(("literal", sig.encode()))
    except FileNotFoundError:
        print("⚠️ signatures.txt not found. Skipping signature scan.")
    return signatures

def scan_file(file_path):
    if not os.path.exists(file_path):
        return [f"❌ File not found: {file_path}"]
    
    report = []
    verdicts = []

    report.append(f"📄 File Scanned: {file_path}")
    file_size = os.path.getsize(file_path)
    report.append(f"📦 File Size: {file_size} bytes")

    filename = os.path.basename(file_path)

    try:
        with open(file_path, "rb") as f:
            contents = f.read()
    except Exception as e:
        return [f"❌ Error reading file: {e}"]

    # Calculate hashes
    md5_hash = hashlib.md5(contents).hexdigest()
    sha1_hash = hashlib.sha1(contents).hexdigest()
    sha256_hash = hashlib.sha256(contents).hexdigest()

    report.extend([
        f"🔐 MD5: {md5_hash}",
        f"🔐 SHA-1: {sha1_hash}",
        f"🔐 SHA-256: {sha256_hash}"
    ])

    # Load hash databases
    md5_hashes = load_all_hashes("hashes", "md5")
    sha1_hashes = load_all_hashes("hashes", "sha1")
    sha256_hashes = load_all_hashes("hashes", "s256")

    if md5_hash in md5_hashes:
        verdicts.append("⚠️ Matched known MD5 malware hash.")
    if sha1_hash in sha1_hashes:
        verdicts.append("⚠️ Matched known SHA-1 malware hash.")
    if sha256_hash in sha256_hashes:
        verdicts.append("⚠️ Matched known SHA-256 malware hash.")

    # Signature matching
    for sig_type, pattern in load_signatures():
        if sig_type == "literal":
            if pattern in contents:
                verdicts.append(f"⚠️ Signature match: {pattern.decode(errors='ignore')}")
        elif sig_type == "regex":
            if pattern.search(contents):
                verdicts.append(f"⚠️ Regex signature match: {pattern.pattern.decode(errors='ignore')}")

    # Entropy
    entropy = calculate_entropy(contents)
    report.append(f"📊 Entropy: {entropy:.2f}")
    if entropy > 7.5:
        verdicts.append("⚠️ High entropy — possibly obfuscated.")

    # Suspicious filename
    if re.search(r'(hacktool|keygen|crack|malware)', filename, re.IGNORECASE):
        verdicts.append("⚠️ Suspicious keyword in filename.")

    # File size heuristics
    if file_size < 100:
        verdicts.append("⚠️ File very small — may be a dropper.")
    elif file_size > 50 * 1024 * 1024:
        verdicts.append("⚠️ File very large — unusual for malware.")

    # Summary
    if not verdicts:
        report.append("✅ Result: No threats detected. File appears safe.")
    else:
        report.append("🚨 Result: Potential threat detected.")
        report.extend(verdicts)

    return report

# 🔹 Laravel akan mengirim file path langsung, tidak perlu input manual!
if __name__ == "__main__":
    if len(sys.argv) < 2:
        print("❌ No file path provided! Exiting...")
        sys.exit(1)

    file_path = sys.argv[1]  # Path langsung dari Laravel
    results = scan_file(file_path)

    print("\n=== SCAN REPORT ===")
    for line in results:
        print(line)