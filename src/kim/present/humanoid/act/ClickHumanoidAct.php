<?php

namespace kim\presenthumanoid\act;

use kim\presenthumanoid\event\PlayerClickHumanoidEvent;

interface ClickHumanoidAct{

	/** @param PlayerClickHumanoidEvent $event */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void;
}