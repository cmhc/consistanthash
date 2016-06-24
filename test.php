<?php
require __DIR__ . '/vendor/autoload.php';
use cmhc\ConsistentHash\ConsistentHash;
$start = microtime(true);
$chash = new ConsistentHash();
$chash->addNodes(array("node1", "node2", "node3", "node4"));
$a = array("node1" => 0, 'node2' => 0, 'node3' => 0, 'node4' => 0);
for ($i = 0; $i < 10000; $i++) {
    $node = $chash->getNode('key' . $i);
    $a[$node] += 1;
}
print_r($a);
echo microtime(true) - $start;
