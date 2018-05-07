<?php

namespace blugin\humanoid\act;

use blugin\humanoid\event\PlayerClickHumanoidEvent;

interface ClickHumanoidAct{

    /** @param PlayerClickHumanoidEvent $event */
    public function onClickHumanoid(PlayerClickHumanoidEvent $event) : void;
}