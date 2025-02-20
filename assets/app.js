
import './styles/app.css';
import React from 'react';
import ReactDOM from 'react-dom';
import Header from './components/Header';
import Footer from './components/Footer';
import ProductList from './js/components/ProductList';

const App = () => {
  return (
    <div>
      <Header />
      <ProductList />
      <Footer />
    </div>
  );
};

ReactDOM.render(<App />, document.getElementById('root'));
