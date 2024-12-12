# milkid-for-php
Milkid for PHP

[Milkid](https://github.com/akirarika/milkid) is a highly customizable distributed unique ID generator written in TypeScript.

# Installation 安装
No installation required, use directly! 无需任何安装，直接使用！

# Usage 使用示例

```php
<?php
use MilkID\IdGenerator;

$generator = new IdGenerator([
    'length' => 24,        // Total length of ID
    'timestamp' => true,   // Include timestamp
    'fingerprint' => true, // Include fingerprint
    'hyphen' => true,      // Add hyphens
    'sequential' => true   // Ensure sequential IDs within same millisecond
]);

$id = $generator->createId('your-unique-fingerprint');
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

