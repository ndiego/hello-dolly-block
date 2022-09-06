/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

import {
	/**
	 * React hook that is used to mark the block wrapper element.
	 * It provides all the necessary props like the class name.
	 *
	 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
	 */
	useBlockProps,

	/**
	 * Components used to display the text alignment control UI.
	 *
	 * @see https://github.com/WordPress/gutenberg/tree/trunk/packages/block-editor/src/components/alignment-control
	 */
	AlignmentControl,
	BlockControls,
} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/developers/block-api/block-edit-save/#edit
 *
 * @param {Object}   param0
 * @param {Object}   param0.attributes
 * @param {string}   param0.attributes.textAlign
 * @param {Function} param0.setAttributes
 * @return {WPElement} Element to render.
 */
export default function Edit( { attributes: { textAlign }, setAttributes } ) {
	// If the text align attribute is set, apply the correct class.
	const blockProps = useBlockProps( {
		className: textAlign ? 'has-text-align-' + textAlign : '',
	} );

	return (
		<>
			<BlockControls group="block">
				<AlignmentControl
					value={ textAlign }
					onChange={ ( nextAlign ) => {
						setAttributes( { textAlign: nextAlign } );
					} }
				/>
			</BlockControls>
			<p { ...blockProps }>
				{ __( 'Well, hello, Dolly', 'hello-dolly-block' ) }
			</p>
		</>
	);
}
