import React from 'react';
import {useAppQuery} from "../hooks"

const SocialAppsContainer = () => {
  const {data:social_apps,isLoading:social_apps_loading} = useAppQuery({
    url : "api/outscraper/social/data",
    tag : ['source_data'],
    reactQueryOptions : {
      onSuccess : (data)=>{
        console.log(data)
      }
    }
  })
  return (
    <>
    {
      social_apps_loading?
      "loading.."
      :
      social_apps.map((e,i)=>
        <img src={e.social_image} key={i} alt="" />
        // <h1>{e.social_image}</h1>
      )
    }
    </>
  )
}

export default SocialAppsContainer