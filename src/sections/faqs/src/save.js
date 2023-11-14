/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor'

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @param {Object} props            Properties passed to the function.
 * @param {Object} props.attributes Available block attributes.
 * @return {Element} Element to render.
 */

import apiFetch from '@wordpress/api-fetch'
import { useState, useEffect } from '@wordpress/element'

export default function save({ attributes }) {
   const blockProps = useBlockProps.save()
   return (
      <div {...blockProps}>
         <div className="flex">
            <h1>FAQs</h1>
            <div>
               {attributes.selectedPosts.map((postId) => (
                  <div key={postId}>
                    <p>{postId}</p>
                     {/*
                          Fetch the post data for each selected FAQ and display featured image, title, and excerpt.
                          Modify the API endpoint path based on your actual WordPress setup.
                      */}
                     {/* <FaqContent faqId={postId} /> */}
                  </div>
               ))}
            </div>
         </div>
      </div>
   )
}

const FaqContent = ({ faqId }) => {
   const [faq, setFaq] = useState(null)

  //  useEffect(() => {
  //     const fetchFaq = async () => {
  //       try {
  //         const fetchedFaq = await apiFetch({
  //             path: `/wp/v2/faqs_cpt/${faqId}`,
  //         })
  //         setFaq(fetchedFaq)
  //       } catch (error) {
  //         console.error(`Error fetching FAQ ${faqId}:`, error)
  //       }
  //     }

  //     fetchFaq()
  //  }, [faqId])

   if (!faq) {
      return null
   }

   return (
      <div>
         {/* {faq.featured_media && (
            <img
               src={faq.featured_media.source_url}
               alt={faq.title.rendered}
               style={{ maxWidth: '100%', height: 'auto' }}
            />
         )} */}
         <h2>{faq.title.rendered}</h2>
         <p>{faqId}</p>
         {/* <div dangerouslySetInnerHTML={{ __html: faq.excerpt.rendered }} /> */}
      </div>
   )
}
