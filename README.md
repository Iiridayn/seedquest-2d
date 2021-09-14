# SeedQuest side site

Run locally to test with `php -S localhost:8008 -c php.ini`.

Image binaries are in the repo. I didn't use `git-lfs` as it doesn't support operation without a central server.

Run `setup.sh` in the lib submodule to get the wordlist.

Requires GD for the placeholder script; might be fine without.

## TODO

* Some unresolved issues with Safari and the popup - for now leave it and track in data analysis

## Notes

`set filename 3d-world-decode-next.png ; import $filename; convert $filename -crop +0+27! -shave 1x1 $filename` to get screenshots

Red circles are drawn in MyPaint (which doesn't give precise numbers for anything, but has cool pressure variation, looks like #FF0000). Arrows are drawn in Inkscape; the undo arrow is at 220/544 (2d, 245/600 for 3d), w/a length of 100, height of 20, and width of 2. The number pointer arrow has the same width and length, but at an upward angle two ticks up when ctrl is held, height 60 - 2d at 655/72, 3d at 660/162. For all, color is r 220, b/g 0.

Need to add `<script src="../report.js"></script>` to the `<head>` of `build/index.html` when updating the build.

Deploy: `rsync -avz --delete Saved_data.csv *.js *.php *.css *.ini build components handlers img lib pages <server>:<dir>`

Pixelated Decoded screen w/a 260x24 rectangle at 160x412 (x210 for 2d mode) in Gimp w/Filters->Blur->Pixelize, block width/height at 5px
- Still looks somewhat like language (good), might provide some usable information w/riser height/character density (bad), but hopefully not enough to impact results.

## .env

See config.inc.php for details. `mode` is required, and must be one of the below
options. If `testing` is present, the site shows additional information for
those testing the study, and enables some testing/debug features to clear the
session and to choose the mode.
```
mode = {registration|followup|final}
(testing = true)
```
