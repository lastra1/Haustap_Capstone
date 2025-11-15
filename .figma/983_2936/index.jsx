import React from 'react';

import styles from './index.module.scss';

const Component = () => {
  return (
    <div className={styles.sIgnup}>
      <img
        src="../image/mhxo5sx8-fri4g8c.png"
        className={styles.braunWeiElegantModer}
      />
      <div className={styles.autoWrapper11}>
        <div className={styles.rectangle252}>
          <p className={styles.signUp}>Sign Up</p>
          <div className={styles.autoWrapper3}>
            <div className={styles.autoWrapper}>
              <p className={styles.firstName}>First Name</p>
              <p className={styles.a}>*</p>
            </div>
            <div className={styles.autoWrapper2}>
              <p className={styles.lastName}>Last Name</p>
              <p className={styles.a2}>*</p>
            </div>
          </div>
          <div className={styles.autoWrapper4}>
            <div className={styles.rectangle2} />
            <div className={styles.rectangle253} />
          </div>
          <div className={styles.autoWrapper5}>
            <div className={styles.firstName2}>
              <div className={styles.rectangle22} />
              <p className={styles.birthdate}>Birthdate</p>
              <p className={styles.mM}>MM</p>
              <p className={styles.a3}>*</p>
            </div>
            <div className={styles.firstName3}>
              <div className={styles.rectangle23} />
              <p className={styles.dD}>DD</p>
              <div className={styles.rectangle3}>
                <img
                  src="../image/mhxo5sx8-2a46lis.png"
                  className={styles.downArrow6}
                />
              </div>
              <p className={styles.yYyy}>YYYY</p>
            </div>
          </div>
          <div className={styles.rectangle24}>
            <p className={styles.signUp2}>sign up</p>
          </div>
          <div className={styles.autoWrapper6}>
            <p className={styles.alreadyHaveAnAccount}>
              Already have an account?&nbsp;
            </p>
            <p className={styles.login}>Login</p>
          </div>
        </div>
        <div className={styles.email5}>
          <div className={styles.autoWrapper7}>
            <div className={styles.rectangle25} />
            <p className={styles.email}>Email</p>
          </div>
          <div className={styles.autoWrapper8}>
            <div className={styles.rectangle25} />
            <p className={styles.email2}>Mobile number</p>
            <p className={styles.a4}>*</p>
          </div>
          <div className={styles.autoWrapper9}>
            <div className={styles.rectangle4}>
              <img src="../image/mhxo5sx8-haoozau.png" className={styles.eye1} />
            </div>
            <p className={styles.email3}>Password</p>
            <p className={styles.a5}>*</p>
          </div>
          <div className={styles.autoWrapper10}>
            <div className={styles.rectangle4}>
              <img src="../image/mhxo5sx8-haoozau.png" className={styles.eye1} />
            </div>
            <p className={styles.email4}>Confirm Password</p>
            <p className={styles.a6}>*</p>
          </div>
        </div>
        <p className={styles.a7}>*</p>
      </div>
    </div>
  );
}

export default Component;
