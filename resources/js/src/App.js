import React, { useState } from "react";
import useToken from "./hooks/useToken";
import Dashboard from "./layouts/Dashboard";
import Login from "./pages/auth/Login";

function App() {

  const { token, setToken } = useToken();
  if (!token) return <Login setToken={setToken} />;

  return (
    <div>
      <Dashboard />
    </div>
  );
}
/*require('dotenv').config();*/
export default App;
