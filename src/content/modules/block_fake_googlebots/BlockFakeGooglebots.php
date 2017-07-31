<?php

class BlockFakeGooglebots extends Controller
{

    public function afterClearCache()
    {
        Database::truncateTable("googlebot_ips");
    }

    public function beforeInit()
    {
        if (GoogleBotCheckHelper::looksLikeGoogleBot()) {
            if (! GoogleBotCheckHelper::isValidGoogleRequest()) {
                header("HTTP/1.0 403 Forbidden");
                echo "Request Blocked: You look like a fake google bot.";
                exit();
            }
        }
    }

    public function uninstall()
    {
        $migrator = new DBMigrator("module/block_fake_googlebots", ModuleHelper::buildModuleRessourcePath("block_fake_googlebots", "sql/down"));
        $migrator->rollback();
    }
}