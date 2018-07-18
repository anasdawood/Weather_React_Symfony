import React, { Component } from 'react';
import { connect } from 'react-redux';
import { getCityDetails, deleteCityFromDashboard } from '../serverCalls/weatherActions';
import { Link } from 'react-router';
import { logUser } from '../actions';
class Details extends Component {

  constructor(props) {
    super(props);
    this.state = {
      details: []
    };
  };

  componentDidMount() {
    const userData = this.saveUserData();
    getCityDetails(this.props.params.dashId).then((data) => {
      this.setState({
        details: data
      });
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
              <th>Humidity</th>
              <th>Time</th>
              <th>Icon</th>
            </tr>
          </thead>
          <tbody>
            {this.state.details && this.state.details.map((city, i) => {
              return (
                <tr key={city.id}>
                  <td>{city.id}</td>
                  <td>{city.temperature}</td>
                  <td>{city.humidity}</td>
                  <td>{city.dateTime}</td>
                  <td><img src={`http://openweathermap.org/img/w/${city.icon}.png`} /></td>
                </tr>);
            })}
          </tbody>
        </table>
        {<Link to="/app" className="btn btn-lg btn-success">+</Link>}
      </div>
    );
  }
}

function mapStateToProps(state) {
  //console.log('state', state);
  // const { email sta = state;
  return state
}
export default connect(mapStateToProps, null)(Details);
