# milkid-for-php
Milkid for PHP

[Milkid](https://github.com/akirarika/milkid) is a highly customizable distributed unique ID generator written in TypeScript.

# Installation 安装
No installation required, use directly! 无需任何安装，直接使用！

# Usage 使用示例

```php
<?php
use MilkID\IdGenerator;

// 基本使用
$generator = new IdGenerator();
$id1 = $generator->createId();

// 带配置的使用
$generator = new IdGenerator([
    'timestamp' => true,     // 包含时间戳
    'fingerprint' => true,   // 包含指纹
    'hyphen' => true,        // 使用连字符
    'length' => 24           // ID总长度
]);

$id2 = $generator->createId('user123');
$id3 = $generator->createId('another-user');

echo $id2; // 输出带有时间戳和指纹的唯一ID
```

# Option 配置选项

- `timestamp`: 是否包含时间戳 (默认: false)
- `fingerprint`: 是否包含指纹 (默认: false)
- `hyphen`: 是否添加连字符 (默认: false)
- `sequential`: 是否使用顺序生成 (默认: true)
- `length`: ID总长度 (默认: 24)
- `magicNumber`: 时间戳基准值 (默认: 733882188971)

# Licence 许可证

MIT 许可证
```

