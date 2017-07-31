<?php

class BlockFakeGooglebots extends Controller
{

    public function uninstall()
    {
        $migrator = new DBMigrator("module/block_fake_googlebots", ModuleHelper::buildModuleRessourcePath("block_fake_googlebots", "sql/down"));
        $migrator->rollback();
    }
}