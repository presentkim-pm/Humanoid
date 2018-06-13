<?php

namespace kim\present\humanoid\act;

use kim\present\humanoid\event\PlayerClickHumanoidEvent;

interface ClickHumanoidAct{

	/** @param PlayerClickHumanoidEvent $event */
	public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void;
}