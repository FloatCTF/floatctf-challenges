#!/usr/bin/env python3
"""
脚本用于生成 challenges.md 文件，其中包含所有题目的信息表格
"""

import urllib.parse
import os
import sys
from collections import Counter

# 尝试导入tomllib (Python 3.11+) 或 tomli
try:
    import tomllib  # Python 3.11+
except ImportError:
    try:
        import tomli as tomllib  # 需要安装: pip install tomli
    except ImportError:
        print("错误: 需要安装 tomli 库。请运行: pip install tomli")
        sys.exit(1)

# 定义挑战目录
CHALLENGES_CATEGORY_DIRS = ["./Web", "./Crypto", "./Misc", "./Pwn", "./Reverse", "./AI"]


def read_meta_toml(challenge_path):
    """读取题目的 meta.toml 文件并提取信息"""
    meta_path = os.path.join(challenge_path, "meta.toml")

    if not os.path.exists(meta_path):
        return None

    try:
        with open(meta_path, "rb") as f:
            meta_data = tomllib.load(f)

        # 提取所需信息
        name = meta_data.get("name", "")
        author = meta_data.get("author", "")
        category = meta_data.get("category", "")
        description = meta_data.get("description", "")
        points = meta_data.get("points", 0)  # 新增

        if isinstance(description, str):
            description = " ".join(description.splitlines())

        return {
            "name": name,
            "author": author,
            "category": category,
            "description": description,
            "points": points,  # 新增
        }
    except Exception as e:
        print(f"读取 {meta_path} 时出错: {e}")
        return None


def generate_challenges_table():
    """生成挑战信息表格"""
    challenges = []

    # 遍历所有挑战目录
    for category_dir in CHALLENGES_CATEGORY_DIRS:
        if not os.path.exists(category_dir):
            continue

        # 遍历该目录下的所有题目
        try:
            for challenge_name in os.listdir(category_dir):
                challenge_path = os.path.join(category_dir, challenge_name)

                # 检查是否为目录
                if not os.path.isdir(challenge_path):
                    continue

                # 读取题目信息
                challenge_info = read_meta_toml(challenge_path)
                if challenge_info:
                    challenges.append(challenge_info)
        except Exception as e:
            print(f"读取目录 {category_dir} 时出错: {e}")
            continue
    # 按分类、作者邮箱、名称排序
    challenges.sort(key=lambda x: (x["category"], x["author"], x["name"]))

    # ---------- 新增：统计分类数量 ----------
    category_counter = Counter([c["category"] for c in challenges])

    # 生成分类统计表格
    md_content = "## Category Summary\n"
    md_content += "| 分类 | 题目数量 |\n"
    md_content += "|------|----------|\n"
    for cat, count in sorted(category_counter.items()):
        md_content += f"| {cat} | {count} |\n"

    # 生成Markdown表格（不包含标题）
    md_content += "## Challenges\n"
    md_content += "| 题目名称 | 分类 | 分值 | 作者 | 描述 |\n"
    md_content += "|---------|------|------|------|------|\n"
    # 按分类、作者邮箱、名称排序
    challenges.sort(key=lambda x: (x["category"], x["author"], x["name"]))

    for challenge in challenges:
        description = challenge["description"].replace("|", "\\|")
        safe_name = urllib.parse.quote(challenge["name"])
        safe_category = urllib.parse.quote(challenge["category"])
        display_name = challenge["name"].replace("'", "&#39;")
        link = f"[{display_name}]({safe_category}/{safe_name}/meta.toml)"

        md_content += (
            f"| {link} | {challenge['category']} | {challenge['points']} "
            f"| {challenge['author']} | {description} |\n"
        )

    return md_content


def update_readme_with_challenges():
    """更新README.md文件中的挑战表格"""
    # 生成挑战表格
    challenges_table = generate_challenges_table()

    # 读取README.md文件
    try:
        with open("README.md", "r", encoding="utf-8") as f:
            readme_content = f.read()
    except Exception as e:
        print(f"读取README.md时出错: {e}")
        return False

    # 替换<challenges>标签之间的内容
    try:
        start_tag = "<challenges>"
        end_tag = "</challenges>"

        start_index = readme_content.find(start_tag)
        end_index = readme_content.find(end_tag)

        if start_index == -1 or end_index == -1:
            print("未找到<challenges>标签")
            return False

        # 确保结束标签在开始标签之后
        if end_index <= start_index:
            print("标签位置不正确")
            return False

        # 替换标签之间的内容（保留标签）
        new_content = (
            readme_content[: start_index + len(start_tag)]
            + "\n\n"
            + challenges_table
            + "\n"
            + readme_content[end_index:]
        )

        # 写入更新后的内容
        with open("README.md", "w", encoding="utf-8") as f:
            f.write(new_content)

        print("README.md 文件已更新！")
        return True
    except Exception as e:
        print(f"更新README.md时出错: {e}")
        return False


def main():
    """主函数"""
    # 生成challenges.md文件
    md_content = generate_challenges_table()

    # 写入文件
    with open("challenges.md", "w", encoding="utf-8") as f:
        # 只写入表格部分，不包含标题
        table_content = md_content.split("\n", 1)[1]  # 去掉第一行标题
        f.write("# Challenges\n\n" + table_content)

    print("challenges.md 文件已生成！")

    # 更新README.md文件
    if update_readme_with_challenges():
        print("README.md 文件已更新！")
    else:
        print("更新 README.md 文件时出错！")


if __name__ == "__main__":
    main()
