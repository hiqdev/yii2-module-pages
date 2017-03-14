# hiqdev/yii2-module-pages

## [0.1.0] - 2017-03-14

- Added reading front matter from Twig comment
    - [b6b3dad] 2017-03-14 renamed readQuotedLines <- getQuoted [@hiqsol]
    - [af6d052] 2017-03-14 added reading front matter from Twig [@hiqsol]
    - [7322082] 2017-03-12 redone extractData to virtual instead of static to become specific for page type [@hiqsol]
    - [dca1067] 2017-03-12 renamed handlers -> pageClasses, added findPageClass [@hiqsol]
    - [45dbd09] 2017-03-12 moved date fixing into extractData [@hiqsol]
    - [4905bd1] 2017-03-04 added looking for README as dir index [@hiqsol]
    - [3eb463b] 2017-03-04 added looking for index in dirs [@hiqsol]
    - [7e74a7d] 2017-03-03 implemented TwigPage [@hiqsol]
    - [452fb7a] 2017-02-28 adding twig rendering [@hiqsol]
    - [fbe1076] 2017-02-26 added require yii2-twig [@hiqsol]
    - [846360c] 2017-02-26 fixed getting date in AbstractPage [@hiqsol]
- Added posts index rendering
    - [ffc1f0f] 2017-02-25 csfixed [@hiqsol]
    - [f9473c7] 2017-02-25 renamed `render/index.php` <- posts.php [@hiqsol]
    - [b1e91e1] 2017-02-25 added posts index rendering [@hiqsol]
    - [ec2113b] 2017-02-22 Made render path relative for actionIndex [@tafid]
- Added basics: twig and php pages rendering
    - [56f508a] 2017-02-22 Added use for InvalidConfigException [@tafid]
    - [85c0097] 2017-02-04 fixed PhpPage to work [@hiqsol]
    - [48437fe] 2017-02-04 added path property to AbstractPage [@hiqsol]
    - [29aa5c3] 2017-01-16 Changed default bhavior if page is null [@tafid]
    - [7dbc887] 2017-01-16 Fixed getDataProvider method [@tafid]
    - [0947518] 2017-01-16 Added dummy php hendler [@tafid]
    - [33eab91] 2017-01-16 Fixed passed param to getMetadata method [@tafid]
    - [1ad8ebd] 2017-01-16 Remove unuseful use [@tafid]
    - [1145773] 2017-01-16 Added TwigPage [@tafid]
    - [d159887] 2017-01-13 Fixed PagesIndex call [@tafid]
    - [9d7804f] 2017-01-13 Made getDataProvider() [@tafid]
    - [a5b302f] 2017-01-13 redoing to `Page` models and more [@hiqsol]
    - [2038e87] 2017-01-13 Fixed message source location [@tafid]
    - [62eb726] 2017-01-13 Added translation config [@tafid]
    - [8f909b9] 2017-01-12 Added composer require to symfony/yaml [@tafid]
    - [b87772a] 2016-09-13 fixed find to look for index in directories [@hiqsol]
    - [aa43c0c] 2016-09-12 implemented handlers for Markdown and PHP [@hiqsol]
    - [b78d791] 2016-09-12 added storage abstraction [@hiqsol]
    - [586e21f] 2016-09-12 added and used GetModuleTrait [@hiqsol]
    - [4e4fc9a] 2016-09-11 inited Module [@hiqsol]
    - [c934b5e] 2016-09-10 added `src/config/hisite.php` [@hiqsol]
    - [215af50] 2016-09-10 inited [@hiqsol]

## [Development started] - 2016-09-10

[@hiqsol]: https://github.com/hiqsol
[sol@hiqdev.com]: https://github.com/hiqsol
[@SilverFire]: https://github.com/SilverFire
[d.naumenko.a@gmail.com]: https://github.com/SilverFire
[@tafid]: https://github.com/tafid
[andreyklochok@gmail.com]: https://github.com/tafid
[@BladeRoot]: https://github.com/BladeRoot
[bladeroot@gmail.com]: https://github.com/BladeRoot
[ffc1f0f]: https://github.com/hiqdev/yii2-module-pages/commit/ffc1f0f
[f9473c7]: https://github.com/hiqdev/yii2-module-pages/commit/f9473c7
[b1e91e1]: https://github.com/hiqdev/yii2-module-pages/commit/b1e91e1
[ec2113b]: https://github.com/hiqdev/yii2-module-pages/commit/ec2113b
[56f508a]: https://github.com/hiqdev/yii2-module-pages/commit/56f508a
[85c0097]: https://github.com/hiqdev/yii2-module-pages/commit/85c0097
[48437fe]: https://github.com/hiqdev/yii2-module-pages/commit/48437fe
[29aa5c3]: https://github.com/hiqdev/yii2-module-pages/commit/29aa5c3
[7dbc887]: https://github.com/hiqdev/yii2-module-pages/commit/7dbc887
[0947518]: https://github.com/hiqdev/yii2-module-pages/commit/0947518
[33eab91]: https://github.com/hiqdev/yii2-module-pages/commit/33eab91
[1ad8ebd]: https://github.com/hiqdev/yii2-module-pages/commit/1ad8ebd
[1145773]: https://github.com/hiqdev/yii2-module-pages/commit/1145773
[d159887]: https://github.com/hiqdev/yii2-module-pages/commit/d159887
[9d7804f]: https://github.com/hiqdev/yii2-module-pages/commit/9d7804f
[a5b302f]: https://github.com/hiqdev/yii2-module-pages/commit/a5b302f
[2038e87]: https://github.com/hiqdev/yii2-module-pages/commit/2038e87
[62eb726]: https://github.com/hiqdev/yii2-module-pages/commit/62eb726
[8f909b9]: https://github.com/hiqdev/yii2-module-pages/commit/8f909b9
[b87772a]: https://github.com/hiqdev/yii2-module-pages/commit/b87772a
[aa43c0c]: https://github.com/hiqdev/yii2-module-pages/commit/aa43c0c
[b78d791]: https://github.com/hiqdev/yii2-module-pages/commit/b78d791
[586e21f]: https://github.com/hiqdev/yii2-module-pages/commit/586e21f
[4e4fc9a]: https://github.com/hiqdev/yii2-module-pages/commit/4e4fc9a
[c934b5e]: https://github.com/hiqdev/yii2-module-pages/commit/c934b5e
[215af50]: https://github.com/hiqdev/yii2-module-pages/commit/215af50
[Under development]: https://github.com/hiqdev/yii2-module-pages/releases
[b6b3dad]: https://github.com/hiqdev/yii2-module-pages/commit/b6b3dad
[af6d052]: https://github.com/hiqdev/yii2-module-pages/commit/af6d052
[7322082]: https://github.com/hiqdev/yii2-module-pages/commit/7322082
[dca1067]: https://github.com/hiqdev/yii2-module-pages/commit/dca1067
[45dbd09]: https://github.com/hiqdev/yii2-module-pages/commit/45dbd09
[4905bd1]: https://github.com/hiqdev/yii2-module-pages/commit/4905bd1
[3eb463b]: https://github.com/hiqdev/yii2-module-pages/commit/3eb463b
[7e74a7d]: https://github.com/hiqdev/yii2-module-pages/commit/7e74a7d
[452fb7a]: https://github.com/hiqdev/yii2-module-pages/commit/452fb7a
[fbe1076]: https://github.com/hiqdev/yii2-module-pages/commit/fbe1076
[846360c]: https://github.com/hiqdev/yii2-module-pages/commit/846360c
[0.1.0]: https://github.com/hiqdev/yii2-module-pages/releases/tag/0.1.0
