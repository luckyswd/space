import './App.css';

import {
  Link,
  useSearchParams,
  useLoaderData,
  json,
  defer,
  Await
} from "react-router-dom";

import {Suspense} from 'react'
import {Spin} from 'antd'

function getPackageLocation () {
  return new Promise((resolve, reject) => {
    setTimeout(() => {
      resolve('5000');
    }, 1000);
  })

}

export async function loader(data) {
  const packageLocationPromise = getPackageLocation();

  return defer({
    packageLocation: packageLocationPromise,
  });
}

function App() {
  const data = useLoaderData();

  console.log(data)


  return (
    <div className="App" style={{ height: '100%' }}>
      <Link to="/login">qweqwe</Link>

      Index page

      <Suspense fallback={<Spin/>}>
        <Await
          resolve={data.packageLocation}
          errorElement={
            <p>Error loading package location!</p>
          }
        >
          {(packageLocation) => (
            <p>
              {packageLocation}
              Your package is at
              lat and long.
            </p>
          )}
        </Await>
      </Suspense>
    </div>
  );
}

export default App;
