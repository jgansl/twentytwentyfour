/**
 * WordPress components that create the necessary UI elements for the block
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-components/
 */
import { PanelBody, RangeControl, TextControl } from "@wordpress/components";

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {
	InnerBlocks,
	InspectorControls,
	PanelColorSettings,
	RichText,
	useBlockProps,
} from "@wordpress/block-editor";

import { __ } from "@wordpress/i18n";

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

// import { __experimentalNumberControl as NumberControl } from "@wordpress/components";
import NumberControl from "./components/number-control";

export default function Edit({ attributes, setAttributes }) {
	// const blockProps = useBlockProps();
	const { columnCount, columnGap, columnWidth } = attributes;
	const columnStyles = { columnCount, columnGap, columnWidth };

	const ALLOWED_BLOCKS = [ 'core/heading', 'core/paragraph', 'core/image' ];
	const TEMPLATE_PARAGRAPHS = [
		'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin finibus, lectus non interdum cursus, arcu sapien mollis lacus, et tincidunt odio nisi ut purus. Duis eleifend, magna placerat faucibus tincidunt, orci nulla ornare tortor, eget egestas tortor nunc quis sem. Cras in tortor justo. Nulla consectetur leo vel blandit consectetur. Fusce quis sapien ante. Vestibulum non varius augue, et ultricies urna. Integer hendrerit suscipit nibh.',
		'Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras vestibulum mauris diam. Praesent semper diam a efficitur iaculis. Nullam lacinia augue quis lorem accumsan tempus. Maecenas dapibus velit eu blandit pretium. Nullam posuere ut ipsum in commodo. Fusce fringilla quis turpis a placerat. Etiam hendrerit velit a lacus varius ornare.',
	];
	const MC_TEMPLATE = [
		[ 'core/heading', { level: 2, placeholder: 'Heading...' } ],
		[ 'core/paragraph', { placeholder: TEMPLATE_PARAGRAPHS[ 0 ] } ],
		[ 'core/heading', { level: 4, placeholder: 'Sub-heading...' } ],
		[ 'core/paragraph', { placeholder: TEMPLATE_PARAGRAPHS[ 1 ] } ],
	];

	// console.log(attributes);

	// const onChangeContent = (val) => {
	// 	setAttributes({ content: val });
	// };

	const onChangeColumnCount = (val) => {
		setAttributes({ columnCount: val });
	};

	const onChangeColumnGap = (val) => {
		setAttributes({ columnGap: Number(val) });
	};
	const onChangeColumnWidth = (val) => {
		setAttributes({ columnWidth: Number(val) });
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title="Column Settings">
					<RangeControl
						label="Columns"
						value={columnCount}
						onChange={onChangeColumnCount}
						min={2}
						max={6}
					/>
					<NumberControl
						label="Gap"
						onChange={onChangeColumnGap}
						value={columnGap}
						min={10}
						max={100}
					/>
					<NumberControl
						label="Width"
						value={columnWidth}
						onChange={onChangeColumnWidth}
						min={120}
						max={500}
						step={10}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...useBlockProps({ style: columnStyles })}>
			<InnerBlocks allowedBlocks={ALLOWED_BLOCKS} template={MC_TEMPLATE} />

			</div>
			{/* <RichText
				{...useBlockProps({ style: columnStyles })}
				tagName="p"
				onChange={onChangeContent}
				value={attributes.content}
				placeholder="Enter some text here..."
			/> */}
		</>
	);
}
