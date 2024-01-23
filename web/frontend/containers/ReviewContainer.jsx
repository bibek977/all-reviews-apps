import React from 'react'
import { useAppQuery } from '../hooks';
import { Spinner } from '@shopify/polaris';

const ReviewContainer = () => {

    const {data : businesses_data,isLoading:business_loading} = useAppQuery({
      url : 'api/outscraper/yelp/business/data',
      tag : ['business_data_fetch'],
      reactQueryOptions: {
        onSuccess : (data)=>{
            // console.log(data)
        }
      }
    })
    const {data : businesses_reviews,isLoading:reviews_loading} = useAppQuery({
      url : 'api/outscraper/yelp/reviews/data',
      tag : ['business_reviews_fetch'],
      reactQueryOptions: {
        onSuccess : (data)=>{
            // console.log(data)
        }
      }
    })
    const {data : amazon_reviews,isLoading:amazon_reviews_loading} = useAppQuery({
      url : 'api/outscraper/amazon/reviews/data',
      tag : ['amazon_reviews_fetch'],
      reactQueryOptions: {
        onSuccess : (data)=>{
            // console.log(data)
        }
      }
    })
    const {data : amazon_product,isLoading:amazon_product_loading} = useAppQuery({
      url : 'api/outscraper/amazon/product/data',
      tag : ['amazon_product_fetch'],
      reactQueryOptions: {
        onSuccess : (data)=>{
            // console.log(data)
        }
      }
    })
    const {data : tripadvisor_reviews,isLoading:tripadvisor_reviews_loading} = useAppQuery({
      url : 'api/outscraper/tripadvisor/reviews/data',
      tag : ['tripadvisor_reviews_fetch'],
      reactQueryOptions: {
        onSuccess : (data)=>{
            // console.log(data)
        }
      }
    })

    const {data : facebook_page,isLoading:facebook_page_loading} = useAppQuery({
      url : 'api/outscraper/facebook/data',
      tag : ['facebook_page_fetch'],
      reactQueryOptions: {
        onSuccess : (data)=>{
            // console.log(data)
        }
      }
    })
    const {data : facebook_reviews,isLoading:facebook_reviews_loading} = useAppQuery({
      url : 'api/outscraper/facebook/reviews/data',
      tag : ['facebook_review_fetch'],
      reactQueryOptions: {
        onSuccess : (data)=>{
            // console.log(data)
        }
      }
    })
    const {data : google_map_new,isLoading:google_map_new_loading} = useAppQuery({
      url : 'api/outscraper/google/data',
      tag : ['google_map_new_fetch'],
      reactQueryOptions: {
        onSuccess : (data)=>{
            // console.log(data)
        }
      }
    })
    const {data : google_reviews,isLoading:google_reviews_loading} = useAppQuery({
      url : 'api/outscraper/google/reviews/data',
      tag : ['google_review_fetch'],
      reactQueryOptions: {
        onSuccess : (data)=>{
            // console.log(data)
        }
      }
    })
  return (
    <>
        {/* {
           business_loading?
           <Spinner accessibilityLabel="Spinner example" size="large"></Spinner>
           :
           "no data" 
        } */}
    </>
  )
}

export default ReviewContainer