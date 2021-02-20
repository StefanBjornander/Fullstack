import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import App from './App';
import * as serviceWorker from './serviceWorker';

class Toggle extends React.Component {
  constructor(props) {
    super(props);
    this.state = {isToggleOn: true};

    // This binding is necessary to make `this` work in the callback
    //this.handleClick = this.handleClick.bind(this);
  }

  handleClick() {
    this.setState(state => ({isToggleOn: !state.isToggleOn}));
  }

  render() {
    return (
      <button onClick={(event) => this.handleClick(event)}>{this.state.isToggleOn ? 'ON' : 'OFF'}</button>
    );
  }
}

ReactDOM.render(
  <Toggle />,
  document.getElementById('root')
);


//ReactDOM.render(<App />, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
