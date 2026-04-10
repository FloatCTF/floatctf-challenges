from pathlib import Path
import zipfile
import requests
import json

ADMIN_USERNAME = "xxxxxx"
ADMIN_PASSWORD = "xxxxxx"
ADMIN_API_ENDPOINT = "https://xxxxxxxx/api/admin"

CHALLENGES_CATEGORY_DIRS = ["./Web", "./Crypto", "./Misc", "./Pwn", "./Reverse", "./AI"]
CHALLENGES_CATEGORY_PATHS = [Path(p) for p in CHALLENGES_CATEGORY_DIRS]
TARGET_DIR = Path("./target")


def zip_directory(
    src_dir: Path, target_zip: Path, recursive: bool = True, exclude: list[Path] = None
):
    """把 src_dir 打包成 zip 文件 target_zip"""
    exclude = exclude or []
    with zipfile.ZipFile(target_zip, "w", zipfile.ZIP_DEFLATED) as zf:
        if recursive:
            for file in src_dir.rglob("*"):
                if file in exclude:
                    continue
                zf.write(file, file.relative_to(src_dir))
        else:
            for file in src_dir.iterdir():
                if file.is_file() and file not in exclude:
                    zf.write(file, file.name)


if __name__ == "__main__":
    # building the target.zip
    # init
    TARGET_DIR.mkdir(parents=True, exist_ok=True)

    # group by the category
    for challenge_category_path in CHALLENGES_CATEGORY_PATHS:
        # handle each
        challenge_dirs = [p for p in challenge_category_path.iterdir() if p.is_dir()]

        if not challenge_dirs:
            # skip the empty
            continue

        # handle the specific category's challenges
        for challenge_dir in challenge_dirs:
            target_path = TARGET_DIR / f"{challenge_dir.name}.zip"
            zip_directory(challenge_dir, target_path)
            print(f"Zipping .... {target_path}")

    # the final target.zip
    target_path = TARGET_DIR / "target.zip"
    zip_directory(TARGET_DIR, target_path, exclude=[target_path])
    print(f"Built at {target_path}")

    # login
    response = requests.post(
        f"{ADMIN_API_ENDPOINT}/session",
        json={"username": ADMIN_USERNAME, "password": ADMIN_PASSWORD},
        verify=False,
    )
    response.raise_for_status()

    resp_json = response.json()
    token = resp_json.get("data")
    # uploading the target.zip
    response = requests.post(
        f"{ADMIN_API_ENDPOINT}/challenges/import",
        headers={"Authorization": f"Bearer {token}"},
        files={"challenge_list_zip": open(target_path, "rb")},
        verify=False,
    )
    response.raise_for_status()
    resp_json = response.json()
    if resp_json["code"] == 0:
        result = []
        challenges_data = resp_json["data"]
        for challenge in challenges_data:
            result.append(
                {
                    "name": challenge["name"],
                    "id": challenge["id"],
                    "category": challenge["category"],
                    "description": challenge["description"],
                }
            )
        with open("challenges.json", "w", encoding="utf-8") as f:
            json.dump(result, f, ensure_ascii=False, indent=2)
        print("Import Successfully, result in challenges.json")
    else:
        print(f"Err in {resp_json}")
