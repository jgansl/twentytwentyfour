/**
 * WordPress components that create the necessary UI elements for the block
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-components/
 */
import { TextControl } from '@wordpress/components';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

// import { registerBlockType } from '@wordpress/blocks';
import { SelectControl } from '@wordpress/components';
import { apiFetch } from '@wordpress/data';
// import { __ } from '@wordpress/i18n';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @param {Object}   props               Properties passed to the function.
 * @param {Object}   props.attributes    Available block attributes.
 * @param {Function} props.setAttributes Function that updates individual attributes.
 *
 * @return {Element} Element to render.
 */
export default async function Edit( { attributes, setAttributes } ) {
	const blockProps = useBlockProps();

	if (attributes.postOptions.length === 0) {
		// Fetch the list of posts if not already fetched
		const posts = await apiFetch({ path: '/wp/v2/posts' });

		// Map the posts to options for SelectControl
		const options = posts.map((post) => ({
			 label: post.title.rendered,
			 value: post.id,
		}));

		setAttributes({ postOptions: options });
  }

  const handlePostSelect = (selectedPosts) => {
		setAttributes({ selectedPosts });
  };

	return (
		<div { ...blockProps }>
			<h3>Select Posts:</h3>
			<SelectControl
				multiple
				value={attributes.selectedPosts}
				onChange={handlePostSelect}
				options={attributes.postOptions}
			/>
		</div>
	);
}
