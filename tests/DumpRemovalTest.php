<?php

use PhpCsFixer\Tokenizer\Tokens;
use Tombenevides\DumpLinter\DumpRemovalFixer;

it('removes dump statement from code', function($input) {
    clearTokenCache();

    $file = getTestFile();

    $fixer = new DumpRemovalFixer();

    $tokens = Tokens::fromCode($input);

    expect($fixer->isCandidate($tokens))->toBeTrue()
        ->and($tokens->isChanged())->toBeFalse();

    $fixer->fix($file, $tokens);

    expect($tokens->isChanged())->toBeTrue()
        ->and($tokens->generateCode())->toBe('<?php  echo "bar";');
})->with([
    '<?php dump("foo"); echo "bar";',
    '<?php var_dump("foo"); echo "bar";',
    '<?php dd("foo"); echo "bar";',
    '<?php dump("foo;;;;;"); echo "bar";',
    '<?php var_dump(";;;foo"); echo "bar";',
    '<?php dd(";;foo;;"); echo "bar";',
]);
