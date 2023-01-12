<?php

namespace Tombenevides\DumpLinter;

use PhpCsFixer\AbstractFunctionReferenceFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\Tokenizer\Tokens;

class DumpRemoval extends AbstractFunctionReferenceFixer
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

    protected function applyFix(\SplFileInfo $file, Tokens $tokens): void
    {
        foreach($this->statements as $index => $statement) {
            while($index !== null){
                $matches = $this->find($statement, $tokens, $index);

                if($matches === null) {
                    break;
                }

                $startFunction = $tokens->getPrevNonWhitespace($matches[0]);

                if($tokens[$startFunction]->isGivenKind(T_NEW) || $tokens[$startFunction]->isGivenKind(T_FUNCTION)) {
                    break;
                }

                $endFunction = $tokens->getNextTokenOfKind($matches[1], [';']);

                $tokens->clearRange($startFunction + 1, $endFunction);
            }
        }
    }
}

