<?php

declare(strict_types=1);
namespace muqsit\wilderness\utils;

use pocketmine\math\Vector3;
use pocketmine\world\ChunkListener;
use pocketmine\world\ChunkLoader;
use pocketmine\world\format\Chunk;
use pocketmine\world\World;

class PopulatedChunkListener implements ChunkLoader, ChunkListener{

	/** @var int */
	private $x;

	/** @var int */
	private $z;

	/** @var World */
	private $world;

	/** @var callable */
	private $callback;

	public function __construct(World $world, int $chunkX, int $chunkZ, callable $callback){
		$this->x = $chunkX;
		$this->z = $chunkZ;
		$this->world = $world;
		$this->callback = $callback;
	}

	public function onChunkLoaded(Chunk $chunk) : void{
		if(!$chunk->isPopulated()){
			$this->world->populateChunk($this->getX(), $this->getZ());
			return;
		}

		$this->onComplete();
	}

	public function onChunkPopulated(Chunk $chunk) : void{
		$this->onComplete();
	}

	private function onComplete() : void{
		$this->world->unregisterChunkLoader($this, $this->getX(), $this->getZ());
		$this->world->unregisterChunkListener($this, $this->getX(), $this->getZ());
		($this->callback)();
	}

	public function getX() : int{
		return $this->x;
	}

	public function getZ() : int{
		return $this->z;
	}

	public function onChunkChanged(Chunk $chunk) : void{
	}

	public function onChunkUnloaded(Chunk $chunk) : void{
	}

	public function onBlockChanged(Vector3 $block) : void{
	}
}