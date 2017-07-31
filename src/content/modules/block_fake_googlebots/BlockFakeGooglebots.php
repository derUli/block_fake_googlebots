<?php

class BlockFakeGooglebots extends Controller
{

    public function uninstall()
    {
        $migrator = new DBMigrator("module/block_fake_googlebots", ModuleHelper::buildModuleRessourcePath("block_fake_googlebots", "sql/down"));
        $migrator->rollback();
    }

    public function beforeInit()
    {
        // @TODO: prüfen ob die IP des Bots bereits in der Datenbak gespeichert hat
        if (GoogleBotCheckHelper::looksLikeGoogleBot()) {
            if (! GoogleBotCheckHelper::isValidGoogleRequest()) {
                // @Todo in Datenbank speichern
                header("HTTP/1.0 403 Forbidden");
                echo "Request Blocked: You look like a fake google bot.";
                exit();
            }
        }
    }
}