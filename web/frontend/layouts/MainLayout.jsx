import { Button, Grid, Layout, Page } from '@shopify/polaris'
import React from 'react'
import SocialAppsContainer from '../containers/SocialAppsContainer'

const MainLayout = () => {
    const modalButton = <Button>Social Apps</Button>
  return (
        <Page
            title='All Reviews App'
            fullWidth
            primaryAction = {modalButton}
        >
          <SocialAppsContainer></SocialAppsContainer>

        </Page>
  )
}

export default MainLayout