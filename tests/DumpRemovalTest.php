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
    'dump()' => '<?php dump("foo"); echo "bar";',
    'var_dump()' => '<?php var_dump("foo"); echo "bar";',
    'dd()' => '<?php dd("foo"); echo "bar";',
    'ray()' => '<?php ray("foo"); echo "bar";',
    'dumps()' => '<?php dumps("foo"); echo "bar";',
    'multiple ; in dump()' => '<?php dump("foo;;;;;"); echo "bar";',
    'multiple ; in var_dump()' => '<?php var_dump(";;;foo"); echo "bar";',
    'multiple ; in dd()' => '<?php dd(";;foo;;"); echo "bar";',
    'multiple ; in ray()' => '<?php ray(";;foo;;"); echo "bar";',
    'multiple ; in dumps()' => '<?php dumps(";;foo;;"); echo "bar";',
]);
