import React, { useState } from 'react'
import SkeletonPageLayout from './SkeletonPageLayout'
import MainLayout from './MainLayout'

const HomeLayout = () => {
    const [skeletonPageLoad,setSkeletonPageLoad] = useState(false)
  return (
    <>
    {
        skeletonPageLoad?
            <SkeletonPageLayout></SkeletonPageLayout>
        :
            <MainLayout></MainLayout>
    }
    </>
  )
}

export default HomeLayout