Graph Statisics Block for Moodle 2.7+
===========

The graph stats block was originally developed by Éric Bugnet (https://github.com/ebugnet/graph_stats) and his repo works correctly on Moodle 2.0 - 2.4 with help from Jean Fruitet.

In Moodle 2.5+ you start to see issues with the block and this is why Wesley Ellis updated the code to work on Moodle 2.5, 2.6+ and also added some new features.

In Moodle 2.7+ block stopped working after changes in Moodle logging procedures. Vadim Dvorovenko has changed code to use Standart log introdueced in Moodle 2.7

Changelog
==========
20140424 by Wesley Ellis 
- Removed Moodle graphing
- Graph is now 100% width (Responsive)
- Changed settings for colours to colour pickers
- Optimized code + tidy up
- Code corrected using Moodle Code Checker

20140423 by Wesley Ellis 
- Check and fixed with Moodle Code Checker
- Changed HTML code to use html::writer API

20140416 by Wesley Ellis 
- Added Simplified Chinese Language pack
- Started running Moodle Code Checker on Block (WIP)

20140415 by Wesley Ellis 
- Working Moodle 2.5+ version committed to repo

20140724 by Vadim Dvorovenko
- 2.7+ version. Taking logs from logstore_standard_log table instead of log table
- Changed to use Moodle Time API for correct working with different timezones
- Changed to use Moodle fullname functions for correct displaing names according to system settings
- Added database request caching to reduce database load
- Changed global settings to plugin settings
- Some other improvements

Moodle Plugin:
https://moodle.org/plugins/view.php?plugin=block_graph_stats