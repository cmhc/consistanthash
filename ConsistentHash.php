<?php
/**
 * achieve consistant hash by php
 * @author  huchao <hu_chao@139.com>
 */
namespace cmhc\ConsistentHash;

class ConsistentHash
{

	/**
	 * nodes array
	 * @var array
	 */
	protected $nodes = array();

	/**
	 * virtual nodes
	 * @var array
	 */
	protected $virtualNodes = array();

	/**
	 * sort
	 * @var boolean
	 */
	protected $isSort = false;

	/**
	 * virtual nodes num
	 * @var integer
	 */
	protected $virtualNodesNum = 10;

	public function __construct()
	{

	}

	/**
	 * in order to more uniform distribution, we need to set a reasonable virtual nodes
	 * @param int $num
	 */
	public function setVirtualNum($num)
	{
		$this->virtualNodesNum = $num;
	}

	/**
	 * add single node
	 * @param string $node
	 */
	public function addNode($node)
	{
		$this->nodes[] = $node;
		for( $i=0; $i<$this->virtualNodesNum; $i++ ){
			$virtualHash = sprintf("%u",crc32($node.$i));
			$this->virtualNodes[$virtualHash] = $node;
		}
		return true;
	}

	/**
	 * add nodes
	 * @param array $nodes
	 */
	public function addNodes($nodes)
	{
		foreach($nodes as $node){
			$this->addNode($node);
		}
	}

	/**
	 * get node name by key
	 * @param  string $key
	 * @return string  node name
	 */
	public function getNode($key)
	{
		if( !$this->isSort ){
			ksort($this->virtualNodes);
			$this->isSort = true;
		}
		$hashKey = sprintf("%u",crc32($key));

		foreach($this->virtualNodes as $hashNode=>$node){
			if( $hashKey < $hashNode ){
				return $node;
			}
		}

		return $this->nodes[0];

	}
}

