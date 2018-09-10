Change Log: `yii2-tabs-x`
=========================

## Version 1.2.6

**Date:** 10-Sep-2018

- (bug #63): Correct and remove unnecessary bootstrap tabs plugin registration.

## Version 1.2.5

**Date:** 06-Sep-2018

- Updates to support Bootstrap 4.x.
- Reorganize all source code in `src` directory.
- (kartik-v/yii2-krajee-base#94): Refactor code and consolidate / optimize properties within traits.

## Version 1.2.4

**Date:** 04-May-2017

- (bug #47): Add missing `hashVarLoadPosition` property.

## Version 1.2.3
    
**Date:** 09-Sep-2016

- (enh #33): Add branch alias for dev-master latest release.
- (enh #35): Correct README for sticky tabs options usage.
- (enh #36, #37): Add printable tabs functionality.
- (enh #41, #42): Better detection of click element for correct sticky tabs initialization.
- Add github contribution and issue/PR logging templates.
- Enhance PHP Documentation for all classes and methods in the extension.


## Version 1.2.2

**Date:** 12-Jan-2016

- (enh #29): Add support for pushState tabs via jquery.stickyTabs plugin.
- (enh #31): Enhancements for PJAX based reinitialization. Complements enhancements in kartik-v/yii2-krajee-base#52 and kartik-v/yii2-krajee-base#53.

## Version 1.2.1

**Date:** 26-Jun-2015

- (enh #17): Add `pluginOptions` to better control TabsX.
- (enh #20): Validate `renderTabContent` property to optionally render panes.
- (enh #23): Enhance TabsX for `yii\bootstrap\Tabs` update.

## Version 1.2.0

**Date:** 05-Mar-2015

- (bug #5): Update renderDropdown for updated release of yii\bootstrap\Tabs.
- Update packagist stats.
- (enh #15): Add pluginEvents property to register TabsX events.
- Set release to stable.
- (enh #16): Parse boolean data attributes correctly in `containerOptions`.

## Version 1.1.0

**Date:** 10-Nov-2014

- Set dependency on Krajee base components
- Set release to stable

## Version 1.0.0

** Date:** 01-Aug-2014

- Initial release
- (bug #1): Use class with correct namespace for `InvalidConfigException`.
- (enh #2): Make items content property optional.
- PSR4 alias change