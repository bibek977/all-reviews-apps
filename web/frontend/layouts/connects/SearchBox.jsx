import { Button, Spinner, Text } from '@shopify/polaris'
import React, { useEffect, useState } from 'react'

const SearchBox = ({platformName}) => {

    const [searchData,setSearchData] = useState('')

    const changeSearchData =(e)=>{
        setSearchData(e.target.value)
    }
    const [socialUrl, setSocialUrl] = useState('');
    const [socialName, setSocialName] = useState('');

    useEffect(() => {
        // This effect runs after the initial render
        if (platformName === "Google") {
          setSocialUrl("ok");
          setSocialName("ok");
        } 
        else if (platformName === "Facebook"){
            setSocialUrl("ok");
            setSocialName("ok");
        }
        else if (platformName === "Yelp"){
            setSocialUrl("ok");
            setSocialName("ok");
        }
        else if (platformName === "Tripadvisor"){
            setSocialUrl("ok");
            setSocialName("ok");
        }
        else if (platformName === "Amazon"){
            setSocialUrl("ok");
            setSocialName("ok");
        }
        else {
          setSocialUrl("n/a");
          setSocialName("n/a");
        }
      }, [platformName]);

    const show_search_data =()=>{
        console.log(searchData)
        console.log(socialUrl);
        console.log(socialName);
    }

    

  return (
    <>
        <div className="search_box_main">
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
        </div>
    </>
  )
}

export default SearchBox