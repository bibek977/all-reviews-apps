import { Button, Spinner, Text } from '@shopify/polaris'
import React, { useState } from 'react'
import { useAppMutation } from '../../../hooks'

const FacebookSearchBox = ({platformName}) => {

    const [searchData,setSearchData] = useState('')

    const changeSearchData =(e)=>{
        setSearchData(e.target.value)
    }

    const show_search_data =()=>{
        create_facebook_page({
            'page_title' : searchData,
          })
    }

    const {mutate:create_facebook_page,isLoading:loading_facebook_page} = useAppMutation({
        url : "api/outscraper/facebook",
        method : "POST",
        reactQueryOptions : {
          onSuccess : (data)=>{
            console.log(data)
            // setActive(data)
          },
        }
      })

  return (
    <>
        {/* <div className="search_box_main">
            <div className="search-box-second">
                <Text as="h3" fontWeight="bold">
                    {platformName} Business Profile Name, Location
                </Text>
            </div>
            <div className="search-input-main">
                <div className="search-input-second">
                    <div className="search-input-third">
                    <input 
                        type="text" 
                        className="search-input-box" 
                        placeholder={`Enter Your ${platformName} Business Profile Name, Location`}
                        autoComplete="off"
                        value={searchData}
                        onChange={changeSearchData} 
                        name=''
                        />
                    </div>
                    <div>
                        <Button id="" onClick={show_search_data}>
                           Send
                        </Button>
                    </div>
                </div>
            </div>
        </div> */}

<div className="grp-entangle-flex" id="grp-entnagle-main-inputs">
      <div className="grp-entangle-label">
        <Text as="h3" fontWeight="bold">
        Facebook Page Name or Link 
        </Text>
      </div>
      <div className="grp-entangle-div-input">
        <div className="grp-entangle-input-indiv">
          <div className="grp-entangle-input-box">
            <p
              className="grp-entangle-search-hover-main"
              id="gr-entangle-button-search"
            >
            
            </p>
            <input
                className="grp-entangle-input"
                id="grp-entnagle-main-input"
                type="text"
                placeholder="Enter Your Google Business Profile Name, Location"
                autoComplete="off"
                value={searchData}
                onChange={changeSearchData} 
                name=''
              />

            <p className="grp-entangle-input-notes grp-entangle-search-hover-main-info">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 48 48"
                className="grp-entangle-info-icon"
              >
                <path
                  fill="#7093EE"
                  d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"
                />
                <path
                  fill="#fff"
                  d="M22 22h4v11h-4V22zM26.5 16.5c0 1.379-1.121 2.5-2.5 2.5s-2.5-1.121-2.5-2.5S22.621 14 24 14 26.5 15.121 26.5 16.5z"
                />
              </svg>
              <span className="grp-entangle-search-hover-info">
                Search for your Facebook page name or FB page link then connect to it.
              </span>
            </p>
          </div>

          <div>
          <Button id="google-place-search" onClick={show_search_data}>
            Send
          </Button>
          </div>
        </div>

      </div>
    </div>
    </>
  )
}

export default FacebookSearchBox