import React, { useState } from 'react'
import SkeletonPageLayout from './SkeletonPageLayout'
import SocialAppsContainer from '../containers/SocialAppsContainer'
import { Button, Page } from '@shopify/polaris'
import ReviewContainer from '../containers/ReviewContainer'

const HomeLayout = () => {
  const modalButton = <Button>Social Apps</Button>
  return (
    <>
        <Page
            title='All Reviews App'
            fullWidth
            primaryAction = {modalButton}
        >
          <SocialAppsContainer></SocialAppsContainer>

          <ReviewContainer></ReviewContainer>

        </Page>
    </>
  )
}

export default HomeLayout