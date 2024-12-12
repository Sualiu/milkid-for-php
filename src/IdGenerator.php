<?php

namespace MilkID;

class IdGenerator {
    private const ENCODING = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    private const ENCODING_FIRST_CHAR = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    private int $lastTime = 0;
    private string $lastDecimal = '0';
    private array $options;
    private int $randLength;
    private string $maxRandCharacter;
    private string $maxRandDecimal;

    public function __construct(array $options = []) {
        $defaultOptions = [
            'length' => 24,
            'timestamp' => true,
            'fingerprint' => false,
            'hyphen' => false,
            'sequential' => true,
            'magicNumber' => 733882188971
        ];

        $this->options = array_merge($defaultOptions, $options);

        $this->randLength = 
            $this->options['length'] + 
            1 - 
            ($this->options['timestamp'] ? 7 : 0) - 
            ($this->options['fingerprint'] ? 5 : 0);

        $this->maxRandCharacter = str_repeat('z', $this->randLength);
        $this->maxRandDecimal = $this->characterToDecimal($this->maxRandCharacter);
    }

    public function createId($fingerprint = null) {
        if ($this->options['fingerprint'] && $fingerprint === null) {
            throw new \Exception("Fingerprint is required");
        }

        $now = (int)(microtime(true) * 1000);
        $id = '';

        // Add timestamp
        if ($this->options['timestamp']) {
            $timestampDecimal = bcsub((string)$now, (string)($this->options['magicNumber'] ?? 733882188971));
            $id .= $this->decimalToCharacter($timestampDecimal);
            $id = substr($id, -7);
        }

        // Add fingerprint
        if ($this->options['fingerprint']) {
            if ($this->options['hyphen']) {
                $id .= '-';
            }

            $fingerprintHash = $this->xxh64($fingerprint);
            $id .= substr($this->decimalToCharacter($fingerprintHash), 2, 5);
        }

        // Add random/sequential part
        if ($this->randLength > 1) {
            if ($this->options['hyphen']) {
                $id .= '-';
            }

            $decimal = $this->getSequentialOrRandomDecimal($now);
            $id .= str_pad(substr($this->decimalToCharacter($decimal), 1), $this->randLength, '0', STR_PAD_LEFT);
        }

        return $id;
    }

    private function getSequentialOrRandomDecimal(int $now): string {
        if ($this->options['sequential'] !== false) {
            if ($this->lastTime !== $now) {
                $this->lastTime = $now;
                $decimal = $this->random($this->maxRandDecimal);
                $this->lastDecimal = $decimal;
            } else {
                $this->lastDecimal = bcadd($this->lastDecimal, '1');
                $decimal = $this->lastDecimal;
            }
            return $decimal;
        }

        return $this->random($this->maxRandDecimal);
    }

    private function decimalToCharacter(string $decimal): string {
        if (bccomp($decimal, '0') === 0) {
            return '0';
        }

        $result = '';
        while (bccomp($decimal, '0') > 0) {
            $remainder = bcmod($decimal, '62');
            $remainderInt = intval($remainder);

            // 安全地选择编码字符
            if ($remainderInt < 52) {
                $result = self::ENCODING_FIRST_CHAR[$remainderInt] . $result;
            } else {
                $result = self::ENCODING[$remainderInt] . $result;
            }

            $decimal = bcdiv($decimal, '62', 0);
        }

        return $result;
    }

    private function characterToDecimal(string $character): string {
        $decimal = '0';
        $base = strlen(self::ENCODING);

        foreach (str_split($character) as $char) {
            $charIndex = strpos(self::ENCODING, $char);
            if ($charIndex === false) {
                $charIndex = strpos(self::ENCODING_FIRST_CHAR, $char);
            }
            
            if ($charIndex !== false) {
                $decimal = bcadd(bcmul($decimal, (string)$base), (string)$charIndex);
            }
        }

        return $decimal;
    }

    private function random(string $limit): string {
        if (bccomp($limit, '0') <= 0) {
            throw new \Exception("Limit must be larger than 0");
        }

        // 使用 random_bytes 生成随机数
        $randomBytes = random_bytes(32);
        $randomDecimal = '0';

        foreach (str_split($randomBytes) as $byte) {
            $randomDecimal = bcadd(bcmul($randomDecimal, '256'), (string)ord($byte));
        }

        return bcdiv(bcmod($randomDecimal, $limit), '1', 0);
    }

    private function xxh64(string $input): string {
        // 简单的哈希实现，可以替换为更复杂的实现，但那实在太慢了（
        return bcadd(base_convert(hash('xxh64', $input), 16, 10), '0');
    }
}
