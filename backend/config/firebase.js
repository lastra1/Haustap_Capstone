const admin = require('firebase-admin');
const logger = require('../utils/logger');

let firebaseApp;

const initializeFirebase = async () => {
  try {
    // Check if Firebase is already initialized
    if (admin.apps.length > 0) {
      firebaseApp = admin.apps[0];
      logger.info('Firebase already initialized');
      return;
    }

    // Initialize Firebase Admin SDK
    const serviceAccountPath = process.env.FIREBASE_CREDENTIALS_PATH || './config/firebase-service-account.json';
    
    try {
      const serviceAccount = require(serviceAccountPath);
      
      firebaseApp = admin.initializeApp({
        credential: admin.credential.cert(serviceAccount),
        databaseURL: process.env.FIREBASE_DATABASE_URL || `https://${process.env.FIREBASE_PROJECT_ID}.firebaseio.com`
      });
      
      logger.info('Firebase Admin SDK initialized successfully');
    } catch (error) {
      logger.warn('Firebase service account not found, using emulator mode');
      // Fallback to emulator mode for development
      firebaseApp = admin.initializeApp({
        projectId: process.env.FIREBASE_PROJECT_ID || 'haustap-booking-system',
        databaseURL: process.env.FIREBASE_DATABASE_URL || 'http://localhost:9000?ns=haustap-booking-system'
      });
    }
  } catch (error) {
    logger.error('Failed to initialize Firebase:', error);
    // Don't throw error, let the app continue without Firebase
  }
};

const getFirebaseApp = () => firebaseApp;
const getFirestore = () => {
  if (!firebaseApp) {
    throw new Error('Firebase not initialized');
  }
  return admin.firestore();
};
const getAuth = () => {
  if (!firebaseApp) {
    throw new Error('Firebase not initialized');
  }
  return admin.auth();
};

module.exports = {
  initializeFirebase,
  getFirebaseApp,
  getFirestore,
  getAuth
};