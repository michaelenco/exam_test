<?php
/**
 * Created by PhpStorm.
 * User: gcorn
 * Date: 7/29/16
 * Time: 2:21 AM
 */

namespace AppBundle\Doctrine;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\SqlWalker;
use Doctrine\ORM\Query\Lexer;

class Rand extends FunctionNode
{
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
    public function getSql(SqlWalker $sqlWalker)
    {
        return 'RAND()';
    }
}