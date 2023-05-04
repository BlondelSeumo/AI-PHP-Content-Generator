<?php

/**
 * Get the category's color.
 *
 * @param $name
 * @return string|void
 */
function categoryColor($name)
{
    switch ($name) {
        case 'content':
            return 'success';
        case 'website':
            return 'danger';
        case 'marketing':
            return 'info';
        case 'social':
            return 'warning';
        case 'custom':
            return 'dark';
    }
}

/**
 * Encode a string for Quill display.
 *
 * @return string
 */
function encodeQuill($input)
{
    return "<p>" . str_replace("\n\n", "<p><br></p>", $input) . "</p>";
}
