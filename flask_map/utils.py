
"""
dictのデバッグ出力
"""
def dump(dictionary):
    s = ""
    for key, value in dictionary.items():
        if s != "":
            s += ", "
        s += f"'{key}':'{value}'"
    print(f"{{{s}}} {type(dictionary)}")
    return s
