import { Box } from '@shopify/polaris'
import React from 'react'
import SearchBox from './SearchBox'

const Connects = ({platformName}) => {
  return (
    <>
    {platformName?
        <Box>
            <Box id='connect_modal_content-box'>

            <div className="connect_modal">
                <p className="connect_modal_content">
                    <b> Connect {platformName} Platform</b>
                </p>
            </div>
            </Box>
            <SearchBox platformName={platformName}></SearchBox>
        </Box>
        :
        "n/a"
    }
    </>
  )
}

export default Connects