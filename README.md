# SeedQuest side site

Run locally to test with `php -S localhost:8008 -c php.ini`.

Image binaries are in the repo. I didn't use `git-lfs` as it doesn't support operation without a central server.

Run `setup.sh` in the lib submodule to get the wordlist.

Requires GD for the placeholder script; might be fine without.

## Notes

`set filename 3d-world-decode-next.png ; import $filename; convert $filename -crop +0+27! -shave 1x1 $filename` to get screenshots

Red circles are drawn in MyPaint (which doesn't give precise numbers for anything, but has cool pressure variation, looks like #FF0000). Arrows are drawn in Inkscape; the undo arrow is at 220/544 (2d, 245/600 for 3d), w/a length of 100, height of 20, and width of 2. The number pointer arrow has the same width and length, but at an upward angle two ticks up when ctrl is held - 2d at 655/72, 3d at 660/162. Color is r 220, the rest 0.
