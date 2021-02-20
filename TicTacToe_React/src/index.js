import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
//import App from './App';
import * as serviceWorker from './serviceWorker';

function Square(props) {
  return (
    <button className="square" onMouseDown={props.onMouseDown}
            onMouseUp={props.onMouseUp}>
      {((props.mark != null) ? props.mark : "")}
    </button>
  );
}

class Board extends React.Component {
  renderSquare(index) {
    return (
      <Square
        mark = {this.props.squares[index]}
        onMouseDown = {() => this.props.onMouseDown(index)}
        onMouseUp = {() => this.props.onMouseUp(index)}
      />
    );
  }

  render() {
    return (        
      <table border="1px">
        <tbody>
          <tr>
            <th colSpan="3">Tic-Tac-Toe</th>
          </tr>
          <tr>
            <td colSpan="3" align="center">
            First player: &nbsp;
            <select disabled={!this.props.init} onChange={this.props.onChange}
                defaultValue={this.props.firstMark}>
                <option value="O">O</option>
                <option value="X">X</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colSpan="3" align="center">Next player: {this.props.nextMark}</td>
          </tr>
          <tr>
            <td>{this.renderSquare(0)}</td>
            <td>{this.renderSquare(1)}</td>
            <td>{this.renderSquare(2)}</td>
          </tr>
          <tr>
            <td>{this.renderSquare(3)}</td>
            <td>{this.renderSquare(4)}</td>
            <td>{this.renderSquare(5)}</td>
          </tr>
          <tr>
            <td>{this.renderSquare(6)}</td>
            <td>{this.renderSquare(7)}</td>
            <td>{this.renderSquare(8)}</td>
          </tr>
        </tbody>
      </table>
    );
  }
}

class Game extends React.Component {
  constructor(props) {
    super(props);
    
    this.state = {
      init: true,
      firstMark: 'O',
      nextMark: 'O',
      pressedIndex: -1,
      squares: Array(9).fill(null)
    };
  }

  onChange(object) {
    this.setState({firstMark: object.target.value,
                   nextMark: object.target.value});
  }
  
  onMouseDown(index) {
    let currMark;
    
    if (this.state.init) {
      currMark = this.state.firstMark;
      this.setState({init: false});
    }
    else {
      currMark = this.state.nextMark;
    }
    
    let matrix = this.state.squares;
    let markFilter = matrix.filter(
      function(square) {
        return (square != null) && square.includes(currMark);
      }
    );

    if (markFilter.length < 3) {
      if (matrix[index] === null) {
        matrix[index] = currMark;
        this.setState({squares: matrix});            

        if (this.checkWinner(currMark)) {
          return;
        }

        this.setState({nextMark: ((currMark === 'O') ? 'X' : 'O')});
      }
      else {
        alert("Square already occupied.")
      }
    }
    else {      
      if (matrix[index] === currMark) {
        this.setState({pressedIndex: index});
      }
      else {
        this.setState({pressedIndex: -1});

        if (matrix[index] === null) {
          alert("Square not occupied.")
        }
        else {
          alert("Square occupied by opponent.")
        }
      }
    }
  }
  
  onMouseUp(index) {
    let currMark = this.state.nextMark,
        pressIndex = this.state.pressedIndex,
        matrix = this.state.squares;

    if ((pressIndex !== -1) && (index !== pressIndex)) {
      if (matrix[index] === null) {
        if (this.checkMove(pressIndex, index)) {
          matrix[pressIndex] = null;
          matrix[index] = currMark;
          this.setState({squares: matrix});            

          if (this.checkWinner(currMark)) {
            return;
          }

          this.setState({nextMark: ((currMark === 'O') ? 'X' : 'O')});
        }
        else {
          alert("Invalid move.")
        }          
      }
      else {
        alert("Square already occupied X.")
      }
    }
  }
  
  checkMove(from, to) {
    const moveArray = [
      [1, 3, 4],
      [0, 2, 3, 4, 5], 
      [1, 4, 5], 
      [0, 1, 4, 6, 7], 
      [0, 1, 2, 3, 5, 6, 7, 8], 
      [1, 2, 4, 7, 8], 
      [3, 4, 7], 
      [3, 4, 5, 6, 8], 
      [4, 5, 7]
    ];
    
    return moveArray[from].includes(to);
  }
  
  checkWinner() {
    const winLines = [
      [0, 1, 2],
      [3, 4, 5],
      [6, 7, 8],
      [0, 3, 6],
      [1, 4, 7],
      [2, 5, 8],
      [0, 4, 8],
      [2, 4, 6]
    ];
    
    const matrix = this.state.squares;
    
    for (let i = 0; i < winLines.length; i++) {
      const [a, b, c] = winLines[i];

      if ((matrix[a] != null) && (matrix[a] === matrix[b]) && (matrix[a] === matrix[c])) {
        alert("Winner: " + matrix[a]);
        
        this.setState({
          init: true,
          pressedIndex: -1,
          squares: Array(9).fill(null)
        });
        
        return true;
      }
    }
    
    return false;
  }
  
  render() {
    return (
      <div className="game">
        <div className="game-board">
          <Board
            firstMark={this.state.firstMark}
            nextMark={this.state.nextMark}
            squares={this.state.squares}
            init={this.state.init}
            onChange={object => this.onChange(object)}
            onMouseDown={index => this.onMouseDown(index)}
            onMouseUp={index => this.onMouseUp(index)}
          />
        </div>
      </div>
    );
  }
}

// ============================================================

ReactDOM.render(<Game/>, document.getElementById("root"));

/*function calculateWinner(squares) {
  const lines = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
  ];
  for (let i = 0; i < lines.length; i++) {
    const [a, b, c] = lines[i];
    if (squares[a] && squares[a] === squares[b] && squares[a] === squares[c]) {
      return squares[a];
    }
  }
  return null;
}

ReactDOM.render(<Game/>, document.getElementById('root'));*/

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
