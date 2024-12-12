# milkid-for-php
Milkid for PHP
PHP版Milkid

⚠️ Attention! This project is currently in an extremely rudimentary initial version with many imperfections. It is highly recommended NOT to be used in a production environment! If possible, please support the original TypeScript project instead.
🚧 本项目当前处于极其简陋的初始版本状态，存在诸多不完善之处，强烈不建议应用于生产环境！如有可能，请为原始的 TypeScript 项目提供支持与助力。

[Milkid](https://github.com/akirarika/milkid) is a highly customizable distributed unique ID generator written in TypeScript.
[Milkid](https://github.com/akirarika/milkid)是一个用TypeScript编写的高度可定制的分布式唯一ID生成器。

# Installation 安装
No installation required, use directly! 无需任何安装，直接使用！

# Usage 使用示例

```php
<?php
use MilkID\IdGenerator;

$generator = new IdGenerator([
    'length' => 24,
    'timestamp' => true,
    'fingerprint' => true,
    'hyphen' => true,
    'sequential' => true   
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

