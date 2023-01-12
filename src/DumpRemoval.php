<?php

namespace Tombenevides\DumpLinter;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

class DumpRemoval implements FixerInterface
{
    private $statements = [
        'var_dump',
        'dump',
        'dd'
    ];

    public function getName(): string
    {
        return 'Tombenevides/dump_removal';
    }

    public function getDefinition(): FixerDefinition
    {
        return new FixerDefinition(
            'Removes dump/var_dump statements from the target code.',
            array(new CodeSample("<?php\nvar_dump(false);"))
        );
    }

    public function isRisky(): bool
    {
        return true;
    }

    public function supports(SplFileInfo $file): bool
    {
        return true;
    }

    public function getPriority(): int
    {
        return 0;
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(T_STRING);
    }

    public function fix(SplFileInfo $file, Tokens $tokens): void
    {
        foreach($tokens as $index => $token)
        {
            if($token->isGivenKind(T_STRING) && in_array($token->getContent(), $this->statements)) {
                $startFunction = $tokens->getPrevNonWhitespace($index);
                $endFunction = $tokens->getNextTokenOfKind($index, [';']);

                $tokens->clearRange($startFunction + 1, $endFunction);
            }
        }
    }

    // public function applyFix(SplFileInfo $file, Tokens $tokens): void
    // {
    //     foreach($this->statements as $index => $statement) {
    //         while($index !== null){
    //             $matches = $this->find($statement, $tokens, $index);

    //             if($matches === null) {
    //                 break;
    //             }

    //             $startFunction = $tokens->getPrevNonWhitespace($matches[0]);

    //             if($tokens[$startFunction]->isGivenKind(T_NEW) || $tokens[$startFunction]->isGivenKind(T_FUNCTION)) {
    //                 break;
    //             }

    //             $endFunction = $tokens->getNextTokenOfKind($matches[1], [';']);

    //             $tokens->clearRange($startFunction + 1, $endFunction);
    //         }
    //     }
    // }
}

