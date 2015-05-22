Plugin for Omeka that adds custom layouts to Exhibit Builder 3.x. All layouts are somewhat responsive (galleries will be one item per row for smaller screens).

**NAL Titlebar**: Adds a colored bar with the item's title above the item's caption.

**NAL Image Gallery**: Provides the option to automatically output Title, Date, Description, and Transcription in the caption area. Also allows a size to be set when attaching only a single image (which will be centered)

**NAL Sidebar List**: Adds a list of items and their titles below the Exhibit navigation. Requires adding `nal_exhibit_builder_render_exhibit_sidebar` to the nav div of `yourtheme/exhibits/show.php` and replacing the page render function with `nal_exhibit_builder_render_exhibit_page`. Only works with themes which show navigation in a sidebar!

**NAL Movie Gallery**: Outputs two Moving Image items per row.
