<?php

namespace presentkim\humanoid\act;

use presentkim\humanoid\event\PlayerClickHumanoidEvent;

interface ClickHumanoidAct{

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void;
}