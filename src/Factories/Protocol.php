<?php

namespace NFePHP\NFe\Factories;

class Protocol
{
    /**
     * addProtMsg
     * @param string $tagproc
     * @param string $tagmsg
     * @param string $xmlmsg
     * @param string $tagretorno
     * @param string $xmlretorno
     * @return string
     */
    public function add($tagproc, $tagmsg, $xmlmsg, $tagretorno, $xmlretorno)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($xmlmsg);
        $node = $dom->getElementsByTagName($tagmsg)->item(0);
        $procver = $node->getAttribute("versao");
        $procns = $node->getAttribute("xmlns");
        
        $dom1 = new \DOMDocument('1.0', 'UTF-8');
        $dom1->formatOutput = false;
        $dom1->preserveWhiteSpace = false;
        $dom1->loadXML($xmlretorno);
        $node1 = $dom1->getElementsByTagName($tagretorno)->item(0);
        
        $proc = new \DOMDocument('1.0', 'UTF-8');
        $proc->formatOutput = false;
        $proc->preserveWhiteSpace = false;
        $procNode = $proc->createElement($tagproc);
        $proc->appendChild($procNode);
        $procNodeAtt1 = $procNode->appendChild($proc->createAttribute('versao'));
        $procNodeAtt1->appendChild($proc->createTextNode($procver));
        $procNodeAtt2 = $procNode->appendChild($proc->createAttribute('xmlns'));
        $procNodeAtt2->appendChild($proc->createTextNode($procns));
        $newnode = $proc->importNode($node, true);
        $procNode->appendChild($newnode);
        $newnode = $proc->importNode($node1, true);
        $procNode->appendChild($newnode);
        $procXML = $proc->saveXML();
        $procXML = Strings::clearProt($procXML);
        return $procXML;
    }
}
