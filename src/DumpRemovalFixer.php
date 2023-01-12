<?php

namespace Tombenevides\DumpLinter;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

final class DumpRemovalFixer implements FixerInterface
{
    private array $statements = [
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
            'Removes dump statements from the target code.',
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
            if(!$this->tokenMatch($token)){
                continue;
            }

            $startFunction = $tokens->getPrevNonWhitespace($index);
            $endFunction = $tokens->getNextTokenOfKind($index, [';']);

            $tokens->clearRange($startFunction + 1, $endFunction);
        }
    }

    private function tokenMatch($token): bool
    {
        return $token->isGivenKind(T_STRING) && in_array($token->getContent(), $this->statements);
    }
}

