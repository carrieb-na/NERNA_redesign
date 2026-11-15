/* Text toolbar buttons for the NERNA book looks. No build step needed. */
( function ( wp ) {
	var el = wp.element.createElement;
	var RichTextToolbarButton = wp.blockEditor.RichTextToolbarButton;
	var toggleFormat = wp.richText.toggleFormat;

	function add( name, title, className, icon ) {
		wp.richText.registerFormatType( name, {
			title: title,
			tagName: 'span',
			className: className,
			edit: function ( props ) {
				return el( RichTextToolbarButton, {
					icon: icon,
					title: title,
					isActive: props.isActive,
					onClick: function () {
						props.onChange( toggleFormat( props.value, { type: name } ) );
					}
				} );
			}
		} );
	}

	add( 'nerna/outline', 'Outline letters (Basic Text)', 'nerna-outline', 'editor-textcolor' );
	add( 'nerna/script', 'Script letters (Spiritual Principle)', 'nerna-script', 'admin-customizer' );
	add( 'nerna/light', 'Light letters (Living Clean)', 'nerna-light', 'editor-paragraph' );
	add( 'nerna/teal', 'Teal letters (Guiding Principles)', 'nerna-teal', 'art' );
	add( 'nerna/sample', 'Sample tag', 'nerna-sample', 'tag' );
} )( window.wp );
