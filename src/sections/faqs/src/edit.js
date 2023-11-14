/**
 * WordPress components that create the necessary UI elements for the block
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-components/
 */
// import { TextControl } from '@wordpress/components'

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor'

// import { registerBlockType } from '@wordpress/blocks';
import { SelectControl } from '@wordpress/components'
// import { apiFetch } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch'
// import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element'
// import { withSelect } from '@wordpress/data';

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
export default function Edit({ attributes, setAttributes }) {
   const blockProps = useBlockProps()
   // const [searchInput, setSearchInput] = useState('')

   // if (attributes.postOptions.length === 0) {
   // 	   // Fetch the list of posts if not already fetched
   // 	   // try {
   // 	const posts = await apiFetch({ path: '/wp/v2/posts' });
   // 		// console.log(posts);
   // 	// } catch (error) {
   // 	// 	// console.error('Error fetching posts:', error);
   // 	// }

   //    // Map the posts to options for SelectControl
   //    const options = posts.map((post) => ({
   //       label: post.title.rendered,
   //       value: post.id,
   //    }))

   //    setAttributes({ postOptions: options })
   // }

   // const { attributes, setAttributes } = props
   const [postOptions, setPostOptions] = useState([])

   useEffect(() => {
      const fetchPosts = async () => {
         try {
            const posts = await apiFetch({ path: '/wp/v2/faqs_cpt' })

            const options = posts.map((post) => ({
               label: post.title.rendered,
               value: post.id,
            }))

            // console.log(options)
            setPostOptions(options)
         } catch (error) {
            console.error('Error fetching faqs:', error)
         }
      }

      // Check if faqOptions is undefined before fetching
		if (!postOptions) {
			setPostOptions([]);
	  }

	  if (postOptions.length === 0) {
			fetchPosts();
	  }
   }, [postOptions])

   const handlePostSelect = (selectedPosts) => {
      setAttributes({ selectedPosts })
   }
   // const handleSearch = (searchValue) => {
   //    setAttributes({ searchValue })
   // }

   return (
      <div {...blockProps}>
         <div class="flex items-start">
            <h1>FAQs</h1>
            <div className="grow">
               <p>Select Posts:</p>
               <SelectControl
                  multiple
                  value={attributes.selectedPosts}
                  onChange={handlePostSelect}
                  options={postOptions}
               />
               {/* <SelectControl
				multiple
            onBlur={function noRefCheck() {}}
            onChange={function noRefCheck() {}}
            onFocus={function noRefCheck() {}}
            options={[
               {
                  disabled: true,
                  label: 'Select an Option',
                  value: '',
               },
               {
                  label: 'Option A',
                  value: 'a',
               },
               {
                  label: 'Option B',
                  value: 'b',
               },
               {
                  label: 'Option C',
                  value: 'c',
               },
            ]}
         /> */}
               {/* <SearchControl
            help="Help text to explain the input."
            label="Label Text"
            value={attributes.searchValue}
            onChange={handleSearch}
            onClose={function noRefCheck() {}}
				/> */}
            </div>
         </div>
      </div>
   )
}
