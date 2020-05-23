<?php

declare(strict_types=1);
namespace muqsit\wilderness\math;

class Random2DCoordinateGenerator{

	/** @var ClosedInterval */
	private $x_interval;

	/** @var ClosedInterval */
	private $y_interval;

	/** @var int */
	private $centerx;

	/** @var int */
	private $centerz;

	/** @var int */
	private $blockedradius;

	public function __construct(int $minx, int $maxx, int $minz, int $maxz, int $centerx, int $centerz, int $blockedradius){
		$this->x_interval = new ClosedInterval($minx, $maxx - $blockedradius * 2);
		$this->y_interval = new ClosedInterval($minz, $maxz - $blockedradius * 2);

		$this->centerx = $centerx;
		$this->centerz = $centerz;
		$this->blockedradius = $blockedradius;
	}

	public function generate() : array{
		$x = $this->x_interval->getRandom();
		if($x > $this->centerx - $this->blockedradius) $x += $this->blockedradius * 2;
		$y = $this->y_interval->getRandom();
		if($y > $this->centerz - $this->blockedradius) $y += $this->blockedradius * 2;
		return [$x, $y];
	}
}