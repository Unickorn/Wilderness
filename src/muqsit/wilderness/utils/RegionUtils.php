<?php

declare(strict_types=1);
namespace muqsit\wilderness\utils;

use pocketmine\world\World;

final class RegionUtils{

	public static function onChunkGenerate(World $world, int $chunkX, int $chunkZ, callable $callback) : void{
		if($world->isChunkPopulated($chunkX, $chunkZ)){
			$callback();
			return;
		}

		$chunk_loader = new PopulatedChunkListener($world, $chunkX, $chunkZ, $callback);
		$world->registerChunkListener($chunk_loader, $chunkX, $chunkZ);
		$world->registerChunkLoader($chunk_loader, $chunkX, $chunkZ, true);
	}
}