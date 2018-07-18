import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getUserDashboard, deleteCityFromDashboard } from '../serverCalls/weatherActions';
import { Link } from 'react-router';


class App extends Component {

  constructor(props) {
    super(props);
    this.state = {
      myDashboard: []
    };
  };

  onDelete(id) {
    deleteCityFromDashboard(id)
      .then((data) => {
        let myDashboard = this.state.myDashboard.filter((city) => {
          return id !== city.id;
        });

        this.setState({ myDashboard: myDashboard });
      })
      .catch((err) => {
        console.error('err', err);
      });
  }


  componentDidMount() {
    const userData = this.saveUserData();
    getUserDashboard(JSON.parse(userData).id).then((data) => {
      this.setState({
        myDashboard: data
      });
      console.log(this.state.myDashboard);
    }
    ).catch((err) => {
      console.error('err', err);
    });
  }
  saveUserData() {

    if (this.props.id != null && this.props.userName != null)
      localStorage.setItem("userData", JSON.stringify({ id: this.props.id, userName: this.props.userName }));
    return localStorage.getItem("userData");
  }

  render() {
   
    return (
      <div>
        <table className="table table-hover table-responsive">
          <thead>
            <tr>
              <th>id</th>
              <th>Temperature</th>
              <th>City Name</th>
              <th>Rain Pos.</th>
              <th>Icon</th>
            </tr>
          </thead>
          <tbody>
            {this.state.myDashboard && this.state.myDashboard.map((city, i) => {
              return (
                <tr key={city.id}>
                  <td>{city.id}</td>
                  <td>{city.temperature}</td>
                  <td>{city.cityName}</td>
                  <td>{city.rainPossibility}</td>
                  <td><img src={`http://openweathermap.org/img/w/${city.icon}.png`} /></td>
                  <td>
                    <Link to={`/city/details/${city.id}`} className="btn btn-default btn-sm">Details</Link>
                    <button onClick={this.onDelete.bind(this, city.id)} className="btn btn-danger btn-sm">Delete</button>
                  </td>
                </tr>);
            })}
          </tbody>
        </table>
        {<Link to="/create" className="btn btn-lg btn-success">+</Link>}
      </div>
    );
  }
}

function mapStateToProps(state) {
  //console.log('state', state);
  // const { email sta = state;
  return state
}
export default connect(mapStateToProps, null)(App);
