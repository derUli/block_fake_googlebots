<?php

class BlockFakeGooglebots extends Controller
{

    public function afterClearCache()
    {
        // Database::truncateTable("googlebot_ips");
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

    public function getSettingsLinkText()
    {
        return get_translation("open");
    }

    public function getSettingsHeadline()
    {
        return "Block Fake Googlebots";
    }

    public function settings()
    {
        $countReal = Database::query("select count(ip) as amount from `{prefix}googlebot_ips` where fake = 0", true);
        $countFake = Database::query("select count(ip) as amount from `{prefix}googlebot_ips` where fake = 1", true);
        
        $countReal = Database::fetchObject($countReal);
        $countFake = Database::fetchObject($countFake);
        
        $countReal = $countReal->amount;
        $countFake = $countFake->amount;
        
        ViewBag::set("count_real", $countReal);
        ViewBag::set("count_fake", $countFake);
        
        return Template::executeModuleTemplate("block_fake_googlebots", "info.php");
    }

    public function uninstall()
    {
        $migrator = new DBMigrator("module/block_fake_googlebots", ModuleHelper::buildModuleRessourcePath("block_fake_googlebots", "sql/down"));
        $migrator->rollback();
    }
}