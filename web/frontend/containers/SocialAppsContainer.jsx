import React, { useCallback, useState } from 'react';
import {useAppQuery} from "../hooks";
import {Frame, Grid, Icon, Modal, Spinner, Thumbnail} from '@shopify/polaris';
import ReviewContainer from './ReviewContainer';
import Connects from '../layouts/connects/Connects';
import FacebookConnects from '../layouts/connects/facebookConnects/FacebookConnects';

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

  const [platformName,setPlatformName] = useState('')

  const [appDataActivate,setAppDataActivate] = useState(false)

  const appDataActivater = useCallback(()=>{
    setAppDataActivate(!appDataActivate),
    [appDataActivate]
  }
  )

  const add_platform =(e)=>{
    console.log(e.social_name)
    setPlatformName(e.social_name)
  }
  return (
    <>
    {
      social_apps_loading?
      <Spinner accessibilityLabel="Spinner example" size="large" />
      :
      social_apps?
      <Grid>
      {
        social_apps?.map((e,i)=>{
          return(
            <>
            <Grid.Cell columnSpan={{xs: 1, sm: 1, md: 1, lg: 1, xl: 1}} key={i}>
              <div
               onClick={()=>{
                add_platform(e),
                appDataActivater()
              }}
              className='social_icons'
              key={i}
               >      
                <Thumbnail
                  source={`assets/${e.social_image}`}
                  alt={e.social_name}
                  >
                </Thumbnail>
              </div>
            </Grid.Cell>
            </>
          )
        })
      }
      </Grid>
      :
      ""
    }

<div
        style={{
          // height:'500px',
          // backgroundColor:'aqua'
          }}>
        <Frame>
          <Modal
            // activator={appDataButton}
            open = {appDataActivate}
            onClose={appDataActivater}
            title = "Connect to Business"
            >

              {/* <Connects platformName={platformName}></Connects> */}

              {platformName === "Facebook" && (
                <FacebookConnects></FacebookConnects>
              )}
              {platformName === "Google" && (
                <FacebookConnects></FacebookConnects>
              )}
              {platformName === "Yelp" && (
                <FacebookConnects></FacebookConnects>
              )}
              {platformName === "Tripadvisor" && (
                <FacebookConnects></FacebookConnects>
              )}
              {platformName === "Amazon" && (
                <FacebookConnects></FacebookConnects>
              )}

          </Modal>
        </Frame>
      </div>
    </>
  )
}

export default SocialAppsContainer

