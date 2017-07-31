<?php
$migrator = new DBMigrator("module/block_fake_googlebots", ModuleHelper::buildModuleRessourcePath("block_fake_googlebots", "sql/up"));
$migrator->migrate();